<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminAuthRuleField extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_auth_rule', function (Blueprint $table) {
            $table->string('rule_val', 100)->change();
            $table->tinyInteger('type')->after('rule_val')->comment('类型 0：菜单 1：按钮');
            $table->string('menu_url', 100)->after('rule_val')->comment('菜单URL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_auth_rule', function (Blueprint $table) {
            $table->string('rule_val', 255)->change();
            $table->dropColumn(['menu_url', 'type']);
        });
    }

}
