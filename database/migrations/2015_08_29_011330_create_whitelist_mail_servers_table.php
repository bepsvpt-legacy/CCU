<?php

use Illuminate\Database\Schema\Blueprint;

class CreateWhitelistMailServersTable extends CustomMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whitelist_mail_servers', function (Blueprint $table) {
            $table->string('domain');

            $table->primary('domain');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('whitelist_mail_servers');
    }
}
