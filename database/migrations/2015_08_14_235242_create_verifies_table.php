<?php

use Illuminate\Database\Schema\Blueprint;

class CreateVerifiesTable extends CustomMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifies', function (Blueprint $table) {
            $table->char('token', 100);
            $table->integer('category_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->timestamp('created_at');

            $table->primary('token');

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
        Schema::table('verifies', function(Blueprint $table) {
            $table->dropForeign('verifies_category_id_foreign');
            $table->dropForeign('verifies_account_id_foreign');
        });

        Schema::drop('verifies');
    }
}
