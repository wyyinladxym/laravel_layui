<?php namespace App\Repositories;

use App\Models\Ad;
use Intervention\Image\ImageManagerStatic as Image;
use Storage;
use Config;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 11:37
 */
class AdRepository
{
    protected $ad;

    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }

    //列表
    public function lists($request)
    {
        $where = 1;
        if ($request->key) {
            $where = 'ad_name like \'%' . $request->key . '%\'';
        }
        return $this->ad->whereRaw($where)->orderBy('sort_order', 'desc')->orderBy('id', 'desc')->paginate($request->limit)->toArray();
    }

    //保存数据
    public function saveData($request, $id = 0)
    {
        if ($id) {
            $result = $this->ad->where('id', $id)->update($request->all());
        } else {
            $result = $this->ad->create($request->all());
            $id = $result->toArray()['id'];
        }
        if (!$result) {
            return resultInfo('编辑失败', 0);
        }
        return resultInfo('编辑成功', 1, $id);
    }

    public function info($id)
    {
        return $this->ad->where('id', $id)->first();
    }

    //上传图片
    public function uploadPic($request)
    {
        if (!$request->hasFile('file_ad_pic')) {
            return resultInfo('未上传文件', 0);
        }

        $file = $request->file('file_ad_pic');

        if (!$file->isValid()) {
            return resultInfo('上传文件无效', 0);
        }

        $file_path = 'ad/' . date('Y-m-d', time()) . '/';
        $file_name = uniqid() . '.' . $file->getClientOriginalExtension();
        $save_file = $file_path . $file_name;
        $put = Storage::disk('public')->put($save_file, file_get_contents($file->getRealPath()));
        if (!$put) {
            return resultInfo('上传失败', 0);
        }
        return resultInfo('上传成功', 1, Config::get('constants.UPLOADS_DIR') . $save_file);
    }

    //删除
    public function destroy($id)
    {
        if (!$id) {
            return resultInfo('参数错误', 0);
        }
        $result = $this->ad->destroy($id);
        if (!$result) {
            return resultInfo('删除失败', 0);
        }
        return resultInfo('删除成功', 1, $id);
    }

}