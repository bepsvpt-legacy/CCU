<?php

namespace App\Ccu\Course;

use App\Ccu\Core\Entity;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        $comment = Comment::where('id', '=', $commentId)
            ->first(['id', 'courses_comment_id', 'agree', 'disagree']);

        // 確認該則留言是否存在，此外，如果是回覆，則需判斷父留言是否存在
        if (null === $comment) {
            return response()->json(['message' => ['留言不存在']], 404);
        } else if ((null !== $comment->getAttribute('courses_comment_id')) && ( ! Comment::where('id', '=', $comment->getAttribute('courses_comment_id'))->exists())) {
            return response()->json(['message' => ['留言不存在']], 404);
        }

        $agree = boolval($agree);

        DB::raw('LOCK TABLES `' . (CommentsVote::getTableName()) . '` WRITE');

        $vote = CommentsVote::where('user_id', '=', $userId)
            ->where('courses_comment_id', '=', $commentId)
            ->first(['id', 'agree']);

        // 如果是取消，則 $vote 不為 null；如果是新增，則 $vote 需為 null
        if ((($withdraw) && (null === $vote)) || (( ! $withdraw) && (null !== $vote))) {
            DB::raw('UNLOCK TABLES');

            return response()->json(['message' => ['不正確的操作']], 422);
        }

        try {
            DB::transaction(function () use ($withdraw, $comment, $vote, $userId, $commentId, $agree) {
                if ($withdraw) {
                    $comment->decrement(($vote->getAttribute('agree')) ? 'agree' : 'disagree');

                    if (true !== $vote->delete()) {
                        throw new Exception;
                    }
                } else {
                    CommentsVote::create(['user_id' => $userId, 'courses_comment_id' => $commentId, 'agree' => $agree, 'created_at' => Carbon::now()]);

                    $comment->increment(($agree) ? 'agree' : 'disagree');

                    if (CommentsVote::where('user_id', '=', $userId)->where('courses_comment_id', '=', $commentId)->count(['id']) > 1) {
                        throw new Exception;
                    }
                }
            });
        } catch (Exception $e) {
            return response()->json(['message' => ['操作失敗，請嘗試重新整理網頁']], 422);
        } finally {
            DB::raw('UNLOCK TABLES');
        }

        return response()->json(['agree' => $comment->getAttribute('agree'), 'disagree' => $comment->getAttribute('disagree')], 200);
    }
}
