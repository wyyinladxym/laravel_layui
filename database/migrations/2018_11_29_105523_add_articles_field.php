<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArticlesField extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->smallInteger('cat_id')->unsigned()->comment('分类id');
            $table->string('video', '120')->comment('视频路径');
            $table->smallInteger('sort_order')->unsigned()->comment('排序');
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
            $table->dropColumn(['cat_id', 'video', 'sort_order']);
        });
    }

}
