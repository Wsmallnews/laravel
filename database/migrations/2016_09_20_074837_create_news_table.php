<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title',50);
            $table->string('description',255);
            $table->text('content');
            $table->tinyInteger('is_top')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }





    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('news')) {     //如果news 表存在，则删除
            Schema::drop('news');
            // Schema::dropIfExists('news');
        }
    }

}
