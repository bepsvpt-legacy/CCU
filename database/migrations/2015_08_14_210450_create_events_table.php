<?php

use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends CustomMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('account_id')->unsigned()->nullable();
            $table->string('action');
            $table->string('detail')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('ip_address', 64)->default('127.0.0.1');
            $table->timestamp('occurred_at');

            $table->index('action');
            $table->index('occurred_at');

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function(Blueprint $table) {
            $table->dropForeign('events_category_id_foreign');
            $table->dropForeign('events_account_id_foreign');
        });

        Schema::drop('events');
    }
}
