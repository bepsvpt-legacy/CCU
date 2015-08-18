<?php

use Illuminate\Database\Schema\Blueprint;

class CreateCoursesCommentsTable extends CustomMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_comments', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('course_id')->unsigned();
            $table->integer('courses_comment_id')->unsigned()->nullable();
            $table->string('content', 1024);
            $table->boolean('anonymous')->default(false);
            $table->smallInteger('agree')->unsigned()->default(0);
            $table->smallInteger('disagree')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('agree');
            $table->index('disagree');
            $table->index('created_at');
            $table->index('deleted_at');

            $table->foreign('user_id')->references('account_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('courses_comment_id')->references('id')->on('courses_comments')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses_comments', function(Blueprint $table) {
            $table->dropForeign('courses_comments_user_id_foreign');
            $table->dropForeign('courses_comments_course_id_foreign');
            $table->dropForeign('courses_comments_courses_comment_id_foreign');
        });

        Schema::drop('courses_comments');
    }
}
