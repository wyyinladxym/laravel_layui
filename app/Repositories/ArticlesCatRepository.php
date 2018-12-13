<?php namespace App\Repositories;

use App\Models\ArticlesCat;
use Cache;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 11:37
 */
class ArticlesCatRepository
{
    protected $articles_cat;

    public function __construct(ArticlesCat $articles_cat)
    {
        $this->articles_cat = $articles_cat;
    }

    //列表
    public function lists($request)
    {
        $where = 1;
        if ($request->key) {
            $where = 'cat_name like \'%' . $request->key . '%\'';
        }
        return $this->articles_cat->whereRaw($where)->orderBy('sort_order', 'desc')->orderBy('id', 'desc')->paginate($request->limit)->toArray();
    }

    //保存数据
    public function saveData($request, $id = 0)
    {
        if ($id) {
            $result = $this->articles_cat->where('id', $id)->update($request->all());
        } else {
            $result = $this->articles_cat->create($request->all());
            $id = $result->toArray()['id'];
        }
        if (!$result) {
            return resultInfo('编辑失败', 0);
        }
        return resultInfo('编辑成功', 1, $id);
    }

    public function info($id)
    {
        return $this->articles_cat->where('id', $id)->first();
    }

    public function getArticles($id)
    {
        return $this->articles_cat->find($id)->articles->toArray();
    }

    //权限树
    public function getTree($pid = null)
    {
        $where = 1;
        if ($pid !== null) {
            $where = 'parent_id = ' . $pid;
        }
        $items = $this->articles_cat->whereRaw($where)->orderBy('sort_order', 'desc')->orderBy('id', 'desc')->get()->toArray();
        return getTree($items);
    }

    //权限树html
    public function getTreeHtml()
    {
        $items = $this->articles_cat->select('*','cat_name as title')->orderBy('sort_order', 'desc')->orderBy('id', 'desc')->get()->toArray();
        return getTreeHtml($items);
    }

    //删除
    public function destroy($id)
    {
        if (!$id) {
            return resultInfo('参数错误', 0);
        }

        $itme = $this->articles_cat->whereIn('parent_id', [$id])->count();
        if ($itme) {
            return resultInfo('删除失败：该分类存有子分类', 0);
        }

        $articles = \App\Models\Article::whereIn('cat_id',[$id])->count();
        if ($articles) {
            return resultInfo('删除失败：该分类下还有文章', 0);
        }

        $result = $this->articles_cat->destroy($id);
        if (!$result) {
            return resultInfo('删除失败', 0);
        }
        return resultInfo('删除成功', 1, $id);
    }

}