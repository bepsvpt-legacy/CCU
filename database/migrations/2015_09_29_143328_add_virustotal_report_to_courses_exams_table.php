<?php

use Illuminate\Database\Schema\Blueprint;

class AddVirustotalReportToCoursesExamsTable extends CustomMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses_exams', function (Blueprint $table) {
            $table->string('virustotal_report', 192)->after('downloads');
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
            $table->dropColumn('virustotal_report');
        });
    }
}
