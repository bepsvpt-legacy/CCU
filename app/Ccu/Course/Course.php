<?php

namespace App\Ccu\Course;

use App\Ccu\Core\Entity;

class Course extends Entity
{
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
    protected $visible = ['id', 'code', 'department', 'dimension', 'name', 'name_en', 'professor'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'department_id', 'dimension_id', 'name', 'name_en', 'professor'];

    /**
     * Get the comments associated with the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Ccu\Course\Comment')
            ->whereNull('courses_comment_id');
    }

    /**
     * Get the department of the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo('App\Ccu\General\Category', 'department_id');
    }

    /**
     * Get the dimension of the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dimension()
    {
        return $this->belongsTo('App\Ccu\General\Category', 'dimension_id');
    }

    /**
     * Get the exams associated with the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exams()
    {
        return $this->hasMany('App\Ccu\Course\Exam');
    }
}