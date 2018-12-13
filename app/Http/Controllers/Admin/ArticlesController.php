<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Repositories\ArticleRepository;
use App\Repositories\ArticlesCatRepository;
use Illuminate\Http\Request;

class ArticlesController extends BaseController
{
    // 任务资源库的实例。
    protected $articles;
    protected $articles_cat;

    public function __construct(ArticleRepository $articles, ArticlesCatRepository $articles_cat)
    {
        parent::__construct();
        $this->articles = $articles;
        $this->articles_cat = $articles_cat;
    }

    public function index()
    {
        return view('admin.articles.index');
    }

    public function lists(Request $request)
    {
        $data = $this->articles->lists($request);
        return resultList($data['data'], $data['total']);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'title' => 'required|max:50'
            ]);
            return $this->articles->saveData($request);
        }
        $result['sub_url'] = $request->url();
        $result['cat_tree'] = $this->articles_cat->getTreeHtml();
        return view('admin.articles.create_and_edit', $result);
    }

    public function edit(Request $request, $id)
    {
        if (!$id) {
            abort(404);
        }
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'title' => 'required|max:50'
            ]);
            return $this->articles->saveData($request, $id);
        }
        $result['data'] = $this->articles->info($id);
        $result['sub_url'] = $request->url();
        $result['cat_tree'] = $this->articles_cat->getTreeHtml();
        return view('admin.articles.create_and_edit', $result);
    }

    //文章图片上传
    public function uploadPic(Request $request)
    {
        return $this->articles->uploadPic($request);
    }

    //文件视频上传
    public function uploadVideo(Request $request)
    {
        return $this->articles->uploadVideo($request);
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
            $up_key = ['sort_order', 'is_top'];
            if (count($edit_data) != 1 || !in_array(key($edit_data), $up_key)) {
                return resultInfo('非法数据', 0);
            }
            return $this->articles->saveData($request, $id);
        }
    }

    //删除
    public function destroy(Request $request)
    {
        return $this->articles->destroy($request->id);
    }
}
