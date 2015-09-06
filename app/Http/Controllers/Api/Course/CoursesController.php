<?php

namespace App\Http\Controllers\Api\Course;

use App\Ccu\Course\Course;
use App\Ccu\Course\CourseSearch;
use App\Ccu\General\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CoursesController extends Controller
{
    public function departments()
    {
        return response()->json(Category::getCategories('courses.department'));
    }

    public function dimensions()
    {
        return response()->json(Category::getCategories('courses.dimension'));
    }

    public function search(Request $request)
    {
        $courses = (new CourseSearch($request->all()))->search();

        return response()->json($courses);
    }

    public function show($courseId = null)
    {
        if ((null === $courseId) || (null === ($course = Course::with(['department'])->find($courseId))))
        {
            throw new NotFoundHttpException;
        }

        return response()->json($course);
    }
}