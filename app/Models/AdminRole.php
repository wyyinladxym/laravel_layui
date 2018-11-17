<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{

    protected $table = 'admin_role';

    //这些属性能被批量赋值
    protected $fillable = ['role_name', 'status', 'remark'];

    //关联权限表
    public function authRules()
    {
       return $this->belongsToMany('App\Models\AdminAuthRule','admin_auth_access', 'role_id', 'rule_id');
    }

}
