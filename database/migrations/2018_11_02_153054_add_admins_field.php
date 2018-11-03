<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminsField extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->renameColumn('nickname', 'real_name');
            $table->string('admin_pic', 120)->after('password')->comment('管理员照片');
            $table->string('phone', 11)->after('password')->comment('手机号码');
        });
        DB::statement("ALTER TABLE `admins` comment'后台管理员表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->renameColumn('real_name', 'nickname');
            $table->dropColumn(['admin_pic', 'phone']);
        });
    }

}
