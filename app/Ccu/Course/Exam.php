<?php

namespace App\Ccu\Course;

use App\Ccu\Core\Entity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Entity
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'courses_exams';

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
    protected $visible = ['id', 'file_name', 'file_size', 'downloads', 'virustotal_report', 'uploaded_at', 'course', 'semester'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'course_id', 'semester_id', 'file_name', 'file_type', 'file_path', 'file_size', 'downloads', 'virustotal_report', 'created_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'deleted_at'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['semester'];

    /**
     * Get the course of the exam.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(\App\Ccu\Course\Course::class);
    }

    /**
     * Get the semester of the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function semester()
    {
        return $this->belongsTo(\App\Ccu\General\Category::class, 'semester_id');
    }
}
