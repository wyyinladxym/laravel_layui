<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    protected $table = 'brands';
    //这些属性能被批量赋值
    protected $fillable = ['brand_name', 'brand_logo', 'sort_order'];


}
