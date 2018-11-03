<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('brands', function(Blueprint $table)
		{
			$table->smallInteger('id',true, true)->comment('自增id');
			$table->string('brand_name', 30)->comment('品牌名称');
			$table->string('brand_logo', 120)->comment('品牌logo');
			$table->smallInteger('sort_order')->unsigned()->comment('排序');
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
		Schema::drop('brands');
	}

}
