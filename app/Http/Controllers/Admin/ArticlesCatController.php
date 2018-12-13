<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;
use App\Repositories\ArticlesCatRepository;


class ArticlesCatController extends BaseController
{
    // 任务资源库的实例。
    protected $articles_cat;

    public function __construct(ArticlesCatRepository $articles_cat)
    {
        parent::__construct();
        $this->articles_cat = $articles_cat;
    }

    public function index()
    {
        return view('admin.articles_cat.index');
    }

    public function lists(Request $request)
    {
        $data = $this->articles_cat->lists($request);
        return resultList($data['data'], $data['total']);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'cat_name' => 'required|max:50',
            ]);
            return $this->articles_cat->saveData($request);
        }
        $result['sub_url'] = $request->url();
        $result['cat_tree'] = $this->articles_cat->getTreeHtml();
        return view('admin.articles_cat.create_and_edit', $result);
    }

    public function edit(Request $request, $id)
    {
        if (!$id) {
            abort(404);
        }
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'cat_name' => 'required|max:50',
            ]);
            return $this->articles_cat->saveData($request, $id);
        }
        $result['data'] = $this->articles_cat->info($id);
        $result['sub_url'] = $request->url();
        $result['cat_tree'] = $this->articles_cat->getTreeHtml();
        return view('admin.articles_cat.create_and_edit', $result);
    }

    //编辑状态
    public function editRow(Request $request, $id)
    {
        if (!$id) {
            return resultInfo('参数错误', 0);
        }
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'sort_order' => 'integer',
            ]);
            $edit_data = $request->all();
            $up_key = ['sort_order', 'is_show', 'show_in_nav'];
            if (count($edit_data) != 1 || !in_array(key($edit_data), $up_key)) {
                return resultInfo('非法数据', 0);
            }
            return $this->articles_cat->saveData($request, $id);
        }
    }

    //删除
    public function destroy(Request $request)
    {
        return $this->articles_cat->destroy($request->id);
    }

}
