<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{

    protected $table = 'ads';
    //这些属性能被批量赋值
    protected $fillable = ['ad_name', 'ad_link', 'ad_pic', 'click_count', 'sort_order', 'sort_order', 'is_show'];


}
