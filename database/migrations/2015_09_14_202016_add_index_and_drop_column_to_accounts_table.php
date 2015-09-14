<?php

use Illuminate\Database\Schema\Blueprint;

class AddIndexAndDropColumnToAccountsTable extends CustomMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->index('remember_token');

            $table->dropColumn(['google2fa_secret', 'google2ga_verified']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropIndex('accounts_remember_token_index');

            $table->char('google2fa_secret', 64)->nullable()->after('password');
            $table->boolean('google2ga_verified')->default(false)->after('google2fa_secret');
        });
    }
}
