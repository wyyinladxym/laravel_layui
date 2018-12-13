<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticlesCat extends Model
{
    protected $table = 'articles_cat';

    //这些属性能被批量赋值
    protected $fillable = ['cat_name', 'parent_id', 'cat_desc', 'show_in_nav', 'sort_order', 'is_show', 'cat_pic'];

    public function articles()
    {
        return $this->hasMany('App\Models\Article', 'cat_id');
    }
}
