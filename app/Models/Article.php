<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    //这些属性能被批量赋值
    protected $fillable = ['title', 'master_pic', 'abstract', 'content', 'is_show', 'show_time', 'browse_num', 'collect_num', 'is_top', 'video', 'cat_id', 'sort_order'];

    public function articlesCat()
    {
        return $this->belongsTo('App\Models\ArticlesCat', 'cat_id');
    }
}
