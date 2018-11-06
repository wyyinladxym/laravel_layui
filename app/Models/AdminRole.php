<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{

    protected $table = 'admin_role';
    //这些属性能被批量赋值
    protected $fillable = ['role_name', 'status', 'remark'];


}
