<?php

namespace App\Http\Controllers\Api\Course;

use App\Ccu\Course\Course;
use App\Ccu\Course\Exam;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExamsController extends Controller
{
    public function index($courseId)
    {
        if (null === ($course = Course::with(['exams'=> function ($query) {$query->orderBy('semester_id', 'desc');}])->find($courseId, ['id'])))
        {
            throw new NotFoundHttpException;
        }

        return response()->json($course->exams);
    }

    public function store(Requests\Courses\ExamsRequest $request, $courseId)
    {
        if ( ! Course::where('id', '=', $courseId)->exists())
        {
            throw new NotFoundHttpException;
        }

        $path = ['dir' => storage_path('uploads/courses/exams'), 'name' => str_random()];

        $exam = Exam::create([
            'user_id' => $request->user()->user->account_id,
            'course_id' => $courseId,
            'semester_id' => $request->input('semester'),
            'file_name' => $request->file('file')->getClientOriginalName(),
            'file_type' => $request->file('file')->getMimeType(),
            'file_path' => "{$path['dir']}/{$path['name']}",
            'file_size' => $request->file('file')->getSize(),
            'created_at' => Carbon::now()
        ]);

        if ( ! $exam->exists)
        {
            throw new InternalErrorException;
        }

        $request->file('file')->move($path['dir'], $path['name']);

        return response()->json($exam);
    }

    public function download(Request $request, $examId)
    {
        if (null === $request->user())
        {
            throw new AccessDeniedHttpException;
        }
        else if (null === ($exam = Exam::find($examId)))
        {
            throw new NotFoundHttpException;
        }

        $exam->increment('downloads');

        return response()->download(
            $exam->getAttribute('file_path'),
            $exam->getAttribute('file_name'),
            [
                'Content-Length' => $exam->getAttribute('file_size'),
                'Content-Type' => $exam->getAttribute('file_type')
            ]
        );
    }
}