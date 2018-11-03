<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminAuthAccessTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_auth_access', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallInteger('role_id')->unsigned()->comment('角色id');
            $table->mediumInteger('rule_id')->unsigned()->comment('规则id');
        });
        DB::statement("ALTER TABLE `admin_auth_access` comment'后台权限授权表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_auth_access');
    }

}
