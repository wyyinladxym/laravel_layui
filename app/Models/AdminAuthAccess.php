<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAuthAccess extends Model
{

    protected $table = 'admin_auth_access';
    //这些属性能被批量赋值
    protected $fillable = ['role_id', 'rule_id'];


}
