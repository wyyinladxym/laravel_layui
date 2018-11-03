<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArticlesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('title', 50)->comment('文章标题');
            $table->string('master_pic', 120)->comment('文章主图');
            $table->smallInteger('cat_id')->unsigned()->index()->comment('分类id');
            $table->string('abstract', 50)->comment('文章摘要');
            $table->text('content')->comment('文章内容');
            $table->tinyInteger('is_show')->index()->comment('发布 0：不发布 1：发布 2：定时发布');
            $table->Integer('show_time')->unsigned()->comment('定时发布时间');
            $table->Integer('browse_num')->unsigned()->comment('浏览量');
            $table->Integer('collect_num')->unsigned()->comment('收藏量');
            $table->tinyInteger('is_top')->comment('置顶 0：默认 1：置顶');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['title', 'master_pic', 'cat_id', 'abstract', 'content', 'is_show', 'show_time', 'browse_num', 'collect_num', 'is_top']);
        });
    }

}
