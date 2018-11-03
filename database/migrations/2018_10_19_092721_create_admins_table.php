<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admins', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('自增id');
            $table->string('username',20)->comment('用户名');
            $table->string('nickname',20)->comment('昵称');
            $table->string('password',60)->comment('密码');
            $table->string('email',60)->unique()->comment('邮箱');
            $table->integer('role_id')->index()->comment('角色id');
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
		Schema::drop('admins');
	}

}
