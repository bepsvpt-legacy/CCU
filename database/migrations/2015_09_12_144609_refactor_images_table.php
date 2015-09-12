<?php

use Illuminate\Database\Schema\Blueprint;

class RefactorImagesTable extends CustomMigration
{
    public function __construct()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        Schema::drop('images');
    }

    public function __destruct()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hash')->unsigned();
            $table->string('mime_type', 16);
            $table->timestamp('uploaded_at');

            $table->unique(['hash', 'uploaded_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hash_1')->unsigned();
            $table->integer('hash_2')->unsigned();
            $table->string('mime_type', 16);

            $table->unique(['hash_1', 'hash_2']);
        });
    }
}
