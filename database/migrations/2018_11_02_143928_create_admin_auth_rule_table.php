<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminAuthRuleTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_auth_rule', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->mediumInteger('id', true, true)->comment('自增主键');
            $table->string('title', 20)->comment('规则中文描述');
            $table->string('rule_val', 255)->comment('规则唯一英文标识,全小写');
            $table->mediumInteger('parent_id')->unsigned()->index()->comment('上级ID');
            $table->mediumInteger('sort_order')->unsigned()->comment('排序');
            $table->string('icon', 20)->comment('图标');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `admin_auth_rule` comment'后台权限规则表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_auth_rule');
    }

}
