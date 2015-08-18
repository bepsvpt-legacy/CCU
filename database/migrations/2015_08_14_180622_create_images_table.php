<?php

use Illuminate\Database\Schema\Blueprint;

class CreateImagesTable extends CustomMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hash_1')->unsigned();
            $table->integer('hash_2')->unsigned();
            $table->string('mime_type', 16);

            $table->unique(['hash_1', 'hash_2']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('images');
    }
}
