<?php

namespace App\Ccu\Course;

use App\Ccu\Core\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Entity
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'courses_comments';

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['id', 'agree', 'anonymous', 'comments', 'content', 'posted_at', 'disagree', 'course', 'user'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'course_id', 'courses_comment_id', 'content', 'anonymous'];

    /**
     * Get the comments associated with the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(\App\Ccu\Course\Comment::class, 'courses_comment_id');
    }

    /**
     * Get the course of the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(\App\Ccu\Course\Course::class)->rememberForever();
    }

    /**
     * Get the user of the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Ccu\Member\User::class)->rememberForever();
    }
}
