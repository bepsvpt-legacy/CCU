<?php

namespace App\Ccu\Course;

use App\Ccu\Core\Entity;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\QueryException;

class CommentsVote extends Entity
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'courses_comments_votes';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['courses_comment_id', 'agree'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'courses_comment_id', 'agree', 'created_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'deleted_at'];

    /**
     * Vote for specific course comment.
     *
     * @param integer $commentId
     * @param integer $userId
     * @param bool $agree
     * @param bool $withdraw
     * @return \Illuminate\Http\JsonResponse
     */
    public static function vote($commentId, $userId, $agree = false, $withdraw = false)
    {
        if (null === ($comment = Comment::where('id', '=', $commentId)->first(['id', 'courses_comment_id', 'agree', 'disagree'])))
        {
            return response()->json(['message' => ['Comment not found.']], 404);
        }
        else if ((null !== $comment->courses_comment_id) && ( ! Comment::where('id', '=', $comment->courses_comment_id)->exists()))
        {
            return response()->json(['message' => ['Comment not found.']], 404);
        }

        $agree = boolval($agree);

        DB::raw('LOCK TABLES `' . (CommentsVote::getTableName()) . '` WRITE');

        $vote = CommentsVote::where('user_id', '=', $userId)->where('courses_comment_id', '=', $commentId)->first(['id', 'agree']);

        if ((($withdraw) && (null === $vote)) || (( ! $withdraw) && (null !== $vote)))
        {
            return response()->json(['message' => ['Vote failed.']], 422);
        }

        try
        {
            DB::transaction(function () use ($withdraw, $comment, $vote, $userId, $commentId, $agree)
            {
                if ($withdraw)
                {
                    $comment->decrement(($vote->agree) ? 'agree' : 'disagree');

                    if (true !== $vote->delete())
                    {
                        throw new Exception;
                    }
                }
                else
                {
                    CommentsVote::create(['user_id' => $userId, 'courses_comment_id' => $commentId, 'agree' => $agree, 'created_at' => Carbon::now()]);

                    $comment->increment(($agree) ? 'agree' : 'disagree');

                    if (CommentsVote::where('user_id', '=', $userId)->where('courses_comment_id', '=', $commentId)->count(['id']) > 1)
                    {
                        throw new Exception;
                    }
                }
            });
        }
        catch(QueryException $e)
        {
            return response()->json(['message' => ['Vote failed.']], 422);
        }
        catch(Exception $e)
        {
            return response()->json(['message' => ['Vote failed.']], 422);
        }
        finally
        {
            DB::raw('UNLOCK TABLES');
        }

        return response()->json(['agree' => $comment->agree, 'disagree' => $comment->disagree], 200);
    }
}