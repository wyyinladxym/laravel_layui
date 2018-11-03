<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRoleTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_role', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallInteger('id', true, true)->comment('自增主键');
            $table->string('role_name', 20)->comment('角色名称');
            $table->tinyInteger('status')->comment('状态 0：冻结 1：正常');
            $table->string('remark', 255)->comment('备注');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `admin_role` comment'后台角色表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_role');
    }

}
