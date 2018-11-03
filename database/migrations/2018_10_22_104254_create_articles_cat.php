<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesCat extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles_cat', function(Blueprint $table)
		{
			$table->smallInteger('id', true, true)->comment('自增主键');
			$table->string('cat_name', 50)->comment('分类名称');
            $table->smallInteger('parent_id')->unsigned()->index()->comment('上级id');
            $table->string('cat_desc', 255)->comment('分类描述');
            $table->smallInteger('sort_order')->unsigned()->comment('排序');
            $table->tinyInteger('show_in_nav')->comment('是否导航显示 0：否 1：是');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('articles_cat');
	}

}
