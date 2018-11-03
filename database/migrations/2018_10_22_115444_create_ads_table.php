<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ads', function(Blueprint $table)
		{
			$table->increments('id')->comment('自增id');
            $table->string('ad_name',50)->comment('广告名称');
            $table->string('ad_link',255)->comment('连接地址');
            $table->string('ad_pic',255)->comment('广告图片');
            $table->integer('click_count')->unsigned()->comment('点击量');
            $table->integer('sort_order')->unsigned()->comment('排序');
            $table->tinyInteger('is_show')->comment('是否显示');
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
		Schema::drop('ads');
	}

}
