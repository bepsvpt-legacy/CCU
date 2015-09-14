<?php

use Illuminate\Database\Schema\Blueprint;

class AddIndexToCoursesExamsTable extends CustomMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses_exams', function (Blueprint $table) {
            $table->index('file_name');
            $table->index('file_size');
            $table->index('downloads');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses_exams', function (Blueprint $table) {
            $table->dropIndex('courses_exams_file_name_index');
            $table->dropIndex('courses_exams_file_size_index');
            $table->dropIndex('courses_exams_downloads_index');
            $table->dropIndex('courses_exams_created_at_index');
        });
    }
}
