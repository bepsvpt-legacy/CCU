<?php

use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends CustomMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->integer('account_id')->unsigned();
            $table->string('nickname', 32);
            $table->integer('profile_picture_id')->unsigned()->nullable()->comment('id of images table');
            $table->timestamps();

            $table->primary('account_id');

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('profile_picture_id')->references('id')->on('images')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropForeign('users_account_id_foreign');
            $table->dropForeign('users_profile_picture_id_foreign');
        });

        Schema::drop('users');
    }
}
