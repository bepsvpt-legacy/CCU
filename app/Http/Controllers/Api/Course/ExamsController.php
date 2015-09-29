<?php

namespace App\Http\Controllers\Api\Course;

use App\Ccu\Course\Course;
use App\Ccu\Course\Exam;
use App\Ccu\General\Event;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Jobs\Courses\ScanExamUploadFiles;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExamsController extends Controller
{
    public function index($courseId)
    {
        $course = Course::with([
            'exams'=> function ($query) {
                $query->orderBy('semester_id', 'desc')->orderBy('downloads', 'desc');
            }
        ])->find($courseId, ['id']);

        if (null === $course) {
            throw new NotFoundHttpException;
        }

        $exams = $course->getRelation('exams')->map(function ($exam) {
            $exam->setAttribute('uploaded_at', $this->convertTimeFieldToHumanReadable($exam->getAttribute('created_at')));

            return $exam;
        });

        return response()->json($exams);
    }

    public function newestHottest()
    {
        $exams = Cache::remember('newestCoursesExams', 60, function () {
            $newest = Exam::with(['course', 'course.department'])->latest()->take(5)->get();

            $hottest = Exam::with(['course', 'course.department'])->orderBy('downloads', 'desc')->take(5)->get();

            return ['newest' => $newest, 'hottest' => $hottest];
        });

        return response()->json($exams);
    }

    public function store(Requests\Courses\ExamsRequest $request, $courseId)
    {
        if ( ! Course::where('id', '=', $courseId)->exists()) {
            throw new NotFoundHttpException;
        }

        $path = ['dir' => storage_path('uploads/courses/exams'), 'name' => str_random()];

        $exam = Exam::create([
            'user_id' => $request->user()->user->account_id,
            'course_id' => $courseId,
            'semester_id' => $request->input('semester'),
            'file_name' => $request->file('file')->getClientOriginalName(),
            'file_type' => $request->file('file')->getMimeType(),
            'file_path' => $path['name'],
            'file_size' => $request->file('file')->getSize(),
            'created_at' => Carbon::now()
        ]);

        if ( ! $exam->exists) {
            throw new InternalErrorException;
        }

        $request->file('file')->move($path['dir'], $path['name']);

        $this->dispatch(new ScanExamUploadFiles($exam));

        return response()->json($exam);
    }

    public function download(Request $request, $examId)
    {
        if (null === $request->user()) {
            throw new AccessDeniedHttpException;
        } else if (null === ($exam = Exam::find($examId))) {
            throw new NotFoundHttpException;
        }

        $exam->increment('downloads');

        Event::_create(
            'events.user',
            $request->user(),
            'user.download',
            collect(['target' => 'courses.exams', 'identify' => $examId])
        );

        return response()->download(
            storage_path('uploads/courses/exams') . '/' . $exam->getAttribute('file_path'),
            $exam->getAttribute('file_name'),
            [
                'Content-Length' => $exam->getAttribute('file_size'),
                'Content-Type' => $exam->getAttribute('file_type')
            ]
        );
    }
}
