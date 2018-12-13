<?php namespace App\Repositories;

use App\Models\Article;
use Storage;
use Config;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 11:37
 */
class ArticleRepository
{
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    //列表
    public function lists($request)
    {
        $where = 1;
        if ($request->key) {
            $where = 'title like \'%' . $request->key . '%\'';
        }
        return $this->article->whereRaw($where)->orderBy('is_top', 'desc')->orderBy('sort_order', 'desc')->paginate($request->limit)->toArray();
    }

    //保存数据
    public function saveData($request, $id = 0)
    {
        if ($request->show_time) {
            $request->offsetSet('show_time', strtotime($request->show_time));
        }
        if ($id) {
            $result = $this->article->where('id', $id)->update($request->all());
        } else {
            $result = $this->article->create($request->all());
            $id = $result->toArray()['id'];
        }
        if (!$result) {
            return resultInfo('编辑失败', 0);
        }
        return resultInfo('编辑成功', 1, $id);
    }

    public function info($id)
    {
        return $this->article->where('id', $id)->first();
    }

    public function getCat($id)
    {
        $article = $this->article->find($id);
        return $article->articlesCat->toArray();
    }

    //文章图片上传
    public function uploadPic($request, $save_dir = 'article')
    {
        if (!$request->hasFile('file')) {
            return resultInfo('未上传文件', 0);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return resultInfo('上传文件无效', 0);
        }

        $file_name = $save_dir . '/' . date('Y-m-d', time()) . '/' . uniqid() . '.' . $file->getClientOriginalExtension();

        $put = Storage::disk('public')->put($file_name, file_get_contents($file->getRealPath()));

        if (!$put) {
            return resultInfo('上传失败', 0);
        }
        $pic['src'] = Config::get('constants.UPLOADS_DIR') . $file_name;
        $result = resultInfo('上传成功', 1, $pic);
        //LayEdit返回如下格式的JSON信息：
        $result['code'] = 0;
        return $result;
    }

    //文章视频上传
    public function uploadVideo($request, $save_dir = 'article_video')
    {
        set_time_limit(500);

        if (!$request->hasFile('file')) {
            return resultInfo('未上传文件', 0);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return resultInfo('上传文件无效', 0);
        }

        $upload_max_filesize = (int)ini_get('upload_max_filesize') * 1024 * 1024;
        if ($file->getClientSize() > $upload_max_filesize) {
            return resultInfo('上传文件大小不能超过' . ($upload_max_filesize / 1024 / 1024) . 'M', 0);
        }

        $ext = $file->getClientOriginalExtension();//得到文件后缀；

        $file_name = $save_dir . '/' . date('Y-m-d', time()) . '/' . uniqid() . '.' . $ext;

        $put = Storage::disk('public')->put($file_name, file_get_contents($file->getRealPath()));

        if (!$put) {
            return resultInfo('上传失败', 0);
        }
        $pic['src'] = Config::get('constants.UPLOADS_DIR') . $file_name;
        $result = resultInfo('上传成功', 1, $pic);
        return $result;
    }

    //删除
    public function destroy($id)
    {
        if (!$id) {
            return resultInfo('参数错误', 0);
        }
        $id = is_array($id) ? $id : func_get_args();
        $result = $this->article->destroy($id);
        if (!$result) {
            return resultInfo('删除失败', 0);
        }
        return resultInfo('删除成功', 1, $id);
    }

}