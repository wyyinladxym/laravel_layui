<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AdRepository;


class AdsController extends Controller
{

    // 任务资源库的实例。
    protected $ads;

    public function __construct(AdRepository $ads)
    {
        $this->ads = $ads;
    }

    public function index()
    {
        return view('admin.ads.index');
    }

    public function lists(Request $request)
    {
        $data = $this->ads->lists($request);
        return resultList($data['data'], $data['total']);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'ad_name' => 'required|max:50',
                'ad_pic' => 'required',
                'sort_order' => 'required|integer',
            ]);
            return $this->ads->saveData($request);
        }
        $result['sub_url'] = $request->url();
        return view('admin.ads.create_and_edit', $result);
    }

    public function edit(Request $request, $id)
    {
        if (!$id) {
            abort(404);
        }
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'ad_name' => 'required|max:50',
                'ad_pic' => 'required',
                'sort_order' => 'required|integer',
            ]);
            return $this->ads->saveData($request, $id);
        }
        $result['data'] = $this->ads->info($id);
        $result['sub_url'] = $request->url();
        return view('admin.ads.create_and_edit', $result);
    }

    //编辑状态
    public function editStatus(Request $request, $id)
    {
        if (!$id) {
            return resultInfo('参数错误', 0);
        }
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'is_show' => 'required|integer',
            ]);
            $edit_data = $request->all();
            if (count($edit_data) != 1 || !isset($edit_data['is_show'])) {
                return resultInfo('非法数据', 0);
            }
            return $this->ads->saveData($request, $id);
        }
    }

    //广告图上传
    public function uploadPic(Request $request)
    {
        return $this->ads->uploadPic($request);
    }

    //删除
    public function destroy(Request $request)
    {
        return $this->ads->destroy($request->id);
    }

}
