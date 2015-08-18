<?php

use Illuminate\Database\Schema\Blueprint;

class CreateDormitoriesRoommatesTable extends CustomMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dormitories_roommates', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->increments('id');
            $table->char('academic', 3);
            $table->char('room', 4);
            $table->char('bed', 1);
            $table->string('name', 8);
            $table->string('fb', 128);
            $table->timestamps();

            $table->unique(['academic', 'room', 'bed']);
            $table->unique('fb');

            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dormitories_roommates');
    }
}
