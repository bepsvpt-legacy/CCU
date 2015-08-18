<?php

use Illuminate\Database\Schema\Blueprint;

class CreateCoursesCommentsVotesTable extends CustomMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_comments_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('courses_comment_id')->unsigned();
            $table->boolean('agree');
            $table->timestamp('created_at');
            $table->softDeletes();

            $table->index('deleted_at');

            $table->foreign('user_id')->references('account_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('courses_comments_votes', function(Blueprint $table) {
            $table->dropForeign('courses_comments_votes_user_id_foreign');
            $table->dropForeign('courses_comments_votes_courses_comment_id_foreign');
        });

        Schema::drop('courses_comments_votes');
    }
}
