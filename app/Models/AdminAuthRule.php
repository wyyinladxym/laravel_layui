<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAuthRule extends Model
{

    protected $table = 'admin_auth_rule';
    //这些属性能被批量赋值
    protected $fillable = ['title', 'rule_val', 'parent_id', 'sort_order', 'icon'];


}
