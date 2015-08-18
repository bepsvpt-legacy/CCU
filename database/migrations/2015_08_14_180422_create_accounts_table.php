<?php

use Illuminate\Database\Schema\Blueprint;

class CreateAccountsTable extends CustomMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', self::EMAIL_LENGTH);
            $table->string('password', 128);
            $table->char('google2fa_secret', 64)->nullable();
            $table->boolean('google2ga_verified')->default(false);
            $table->rememberToken();
            $table->timestamps();

            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('accounts');
    }
}
