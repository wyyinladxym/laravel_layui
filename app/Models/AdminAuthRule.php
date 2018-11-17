<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAuthRule extends Model
{
    protected $table = 'admin_auth_rule';

    //这些属性能被批量赋值
    protected $fillable = ['title', 'rule_val', 'parent_id', 'menu_url', 'type', 'sort_order', 'icon'];

    //所有的关联将会被连动。
    //protected $touches = ['admin_role'];

    //关联角色表
    public function roles()
    {
        return $this->belongsToMany('App\Models\AdminRole','admin_auth_access', 'rule_id', 'role_id');
    }
}
