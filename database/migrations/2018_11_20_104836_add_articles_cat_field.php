<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArticlesCatField extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles_cat', function (Blueprint $table) {
            $table->tinyInteger('is_show')->comment('是否显示：0 隐藏 1 显示');
            $table->string('cat_pic', 155)->comment('分类图片');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles_cat', function (Blueprint $table) {
            $table->dropColumn(['is_show', 'cat_pic']);
        });
    }

}
