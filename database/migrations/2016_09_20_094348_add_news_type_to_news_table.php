<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewsTypeToNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news', function($table) {
            $table->string('news_type',4)->after('title');   //新增字段，插入到title的后面，好像插入不管用，并且好像不能增加smallInteger类型字段
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // if (Schema::hasColumn('news', 'news_type')) {
        Schema::table('news', function($table) {
            $table->dropColumn('news_type');
        });
        // }
    }
}
