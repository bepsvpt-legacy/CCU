<?php

use Illuminate\Database\Schema\Blueprint;

class CreateCoursesExamsTable extends CustomMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_exams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('course_id')->unsigned();
            $table->integer('semester_id')->unsigned();
            $table->string('file_name');
            $table->string('file_type', 32);
            $table->string('file_path');
            $table->mediumInteger('file_size')->unsigned();
            $table->mediumInteger('downloads')->unsigned()->default(0);
            $table->timestamp('created_at');
            $table->softDeletes();

            $table->index('deleted_at');

            $table->foreign('user_id')->references('account_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('semester_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses_exams', function(Blueprint $table) {
            $table->dropForeign('courses_exams_user_id_foreign');
            $table->dropForeign('courses_exams_course_id_foreign');
            $table->dropForeign('courses_exams_semester_id_foreign');
        });

        Schema::drop('courses_exams');
    }
}
