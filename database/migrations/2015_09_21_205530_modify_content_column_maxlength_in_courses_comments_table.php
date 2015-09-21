<?php

use Illuminate\Database\Schema\Blueprint;

class ModifyContentColumnMaxlengthInCoursesCommentsTable extends CustomMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses_comments', function (Blueprint $table) {
            $table->string('content', self::UTF8MB4_MAX_VARCHAR)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses_comments', function (Blueprint $table) {
            $table->string('content', 1024)->change();
        });
    }
}
