<?php

namespace App\Http\Controllers\Api\Course;

use App\Ccu\Course\Comment;
use App\Ccu\Course\Course;
use App\Ccu\Course\CommentsVote;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentsController extends Controller
{
    public function index($courseId = null)
    {
        if ((null === $courseId) || null === ($course = Course::find($courseId, ['id'])))
        {
            throw new NotFoundHttpException;
        }

        $comments = $course->comments()->with(['user', 'comments', 'comments.user'])->latest()->paginate(5);

        $this->parsingComments($comments->items());

        return response()->json($comments);
    }

    public function parsingComments($comments, $recursive = false)
    {
        foreach ($comments as $comment)
        {
            if (( ! $recursive) && count($subComments = $comment->getAttribute('comments')))
            {
                $this->parsingComments($subComments, true);
            }

            if (true === (bool) $comment->getAttribute('anonymous'))
            {
                $comment->offsetUnset('user_id');
                $comment->offsetUnset('user');
            }

            $comment->setAttribute('posted_at', collect(['date' => $comment->created_at->toDateTimeString(), 'human' => $comment->getAttribute('created_at')->diffForHumans(Carbon::now())]));
        }
    }

    public function store(Requests\CoursesCommentsRequest $request, Guard $guard, $courseId, $commentId = null)
    {
        if ( ! Course::where('id', '=', $courseId)->exists())
        {
            throw new NotFoundHttpException;
        }
        else if ((null !== $commentId) && ( ! Comment::where('course_id', '=', $courseId)->where('id', '=', $commentId)->exists()))
        {
            throw new NotFoundHttpException;
        }

        $comment = Comment::create([
            'user_id' => $guard->user()->user->account_id,
            'course_id' => $courseId,
            'courses_comment_id' => $commentId,
            'content' => $request->input('content'),
            'anonymous' => boolval($request->input('anonymous', false))
        ]);

        return response()->json($comment);
    }

    public function getVotes(Request $request)
    {
        if (null === $request->user())
        {
            return response()->json([]);
        }

        return response()->json($request->user()->user->votes);
    }

    public function vote(Request $request, Guard $guard, $commentId, $withdraw = false)
    {
        return CommentsVote::vote($commentId, $guard->user()->user->account_id, boolval($request->input('agree', false)), $withdraw);
    }

    public function voteWithdraw(Request $request, Guard $guard, $commentId)
    {
        return $this->vote($request, $guard, $commentId, true);
    }
}