<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('classify_id')->nullable()->comment('主题分类');    // 分类
            $table->string('title',255)->nullable();
            $table->string('abstract',255)->nullable()->comment('摘要'); // 摘要
            $table->text('body')->nullable();        // 内容
            $table->text('body_original')->nullable();        // markdown内容
            $table->tinyInteger('is_top')->default(0);
            $table->tinyInteger('is_elite')->default(0)->comment('是否加精');    // 是否加精
            $table->integer('view_num')->default(0);            // 查看数量
            $table->integer('review_num')->default(0)->comment('评论数量');          // 评论
            $table->integer('support_num')->default(0)->comment('点赞数量');         // 点赞数量
            $table->timestamp('actived_at')->nullable()->comment('最后活跃时间');         // 最后活跃时间
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
        Schema::drop('topics');
    }
}
