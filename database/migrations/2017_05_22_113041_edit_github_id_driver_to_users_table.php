<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditGithubIdDriverToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('driver', 'source_driver');
            $table->integer('qq_id')->nullable();
            $table->integer('weibo_id')->nullable();
            $table->integer('twitter_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('source_driver', 'driver');
            $table->dropColumn('qq_id');
            $table->dropColumn('weibo_id');
            $table->dropColumn('twitter_id');
        });
    }
}
