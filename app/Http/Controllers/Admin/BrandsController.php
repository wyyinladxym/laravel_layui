<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;
use Storage;
use Config;
use App\Repositories\BrandRepository;

class BrandsController extends BaseController
{
    // 任务资源库的实例。
    protected $brands;

    public function __construct(BrandRepository $brands)
    {
        parent::__construct();
        $this->brands = $brands;
    }

    public function index()
    {
        return view('admin.brands.index');
    }

    public function lists(Request $request)
    {
        $data = $this->brands->lists($request);
        return resultList($data['data'], $data['total']);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'brand_name' => 'required|max:30',
                'brand_logo' => 'required',
                'sort_order' => 'required|integer',
            ]);
            return $this->brands->saveData($request);
        }
        $result['sub_url'] = $request->url();
        return view('admin.brands.create_and_edit', $result);
    }

    public function edit(Request $request, $id)
    {
        if (!$id) {
            abort(404);
        }
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'brand_name' => 'required|max:30',
                'brand_logo' => 'required',
                'sort_order' => 'required|integer',
            ]);
            return $this->brands->saveData($request, $id);
        }
        $result['data'] = $this->brands->info($id);
        $result['sub_url'] = $request->url();
        return view('admin.brands.create_and_edit', $result);
    }

    //品牌logo上传
    public function uploadLogo(Request $request)
    {
        return $this->brands->uploadLogo($request);
    }

    //删除
    public function destroy(Request $request)
    {
        return $this->brands->destroy($request->id);
    }

}
