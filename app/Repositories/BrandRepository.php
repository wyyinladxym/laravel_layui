<?php namespace App\Repositories;

use App\Models\Brand;
use Storage;
use Config;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 11:37
 */
class BrandRepository
{
    protected $brand;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    //列表
    public function lists($request)
    {
        $where = 1;
        if ($request->key) {
            $where = 'brand_name like \'%' . $request->key . '%\'';
        }
        return $this->brand->whereRaw($where)->orderBy('sort_order', 'desc')->orderBy('id', 'desc')->paginate($request->limit)->toArray();
    }

    //保存数据
    public function saveData($request, $id = 0)
    {
        if ($id) {
            $result = $this->brand->where('id', $id)->update($request->all());
        } else {
            $result = $this->brand->create($request->all());
            $id = $result->toArray()['id'];
        }
        if (!$result) {
            return resultInfo('编辑失败', 0);
        }
        return resultInfo('编辑成功', 1, $id);
    }

    public function info($id)
    {
        return $this->brand->where('id', $id)->first();
    }

    //上传logo
    public function uploadLogo($request)
    {
        if (!$request->hasFile('file_brand_logo')) {
            return resultInfo('未上传文件', 0);
        }

        $file = $request->file('file_brand_logo');

        if (!$file->isValid()) {
            return resultInfo('上传文件无效', 0);
        }

        $file_name = 'brand/' . date('Y-m-d', time()) . '/' . uniqid() . '.' . $file->getClientOriginalExtension();

        $put = Storage::disk('public')->put($file_name, file_get_contents($file->getRealPath()));

        if (!$put) {
            return resultInfo('上传失败', 0);
        }
        return resultInfo('上传成功', 1, Config::get('constants.UPLOADS_DIR') . $file_name);
    }

    //删除
    public function destroy($id)
    {
        if (!$id) {
            return resultInfo('参数错误', 0);
        }
        $result = $this->brand->destroy($id);
        if (!$result) {
            return resultInfo('删除失败', 0);
        }
        return resultInfo('删除成功', 1, $id);
    }

}