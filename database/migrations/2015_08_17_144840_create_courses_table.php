<?php

use Illuminate\Database\Schema\Blueprint;

class CreateCoursesTable extends CustomMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->increments('id');
            $table->char('code', 7);
            $table->integer('department_id')->unsigned();
            $table->integer('dimension_id')->unsigned()->nullable();
            $table->string('name', 48);
            $table->string('name_en', 96);
            $table->string('professor', 24);

            $table->index('code');
            $table->index('name');
            $table->index('name_en');
            $table->index('professor');

            $table->foreign('department_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('dimension_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function(Blueprint $table) {
            $table->dropForeign('courses_department_id_foreign');
            $table->dropForeign('courses_dimension_id_foreign');
        });

        Schema::drop('courses');
    }
}
