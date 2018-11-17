<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model {

	//这些属性能被批量赋值
    protected $fillable = ['username', 'nickname', 'password', 'email', 'role_id', 'status', 'admin_pic'];

}
