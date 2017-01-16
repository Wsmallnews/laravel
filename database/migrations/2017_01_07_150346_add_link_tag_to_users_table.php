<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinkTagToTopicsTable extends Migration
{
    /**
     * to topics添加字段，发布时间
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('personal_website', 255)->nullable()->comment('个人网站');
            $table->string('wechat_qrcode', 255)->nullable()->comment('微信二维码');
            $table->string('qq_qrcode', 255)->nullable()->comment('qq 二维码');
            $table->string('linked_in', 255)->nullable()->comment('领英个人首页');
            $table->string('company', 255)->nullable()->comment('公司');
            $table->string('pay_me', 255)->nullable()->comment('向我付款');
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
            $table->dropColumn('personal_website');
            $table->dropColumn('wechat_qrcode');
            $table->dropColumn('qq_qrcode');
            $table->dropColumn('linked_in');
            $table->dropColumn('company');
            $table->dropColumn('pay_me');
        });
    }
}
