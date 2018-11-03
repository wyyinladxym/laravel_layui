<?php namespace App\Repositories;

use App\Models\AdminAuthRule;
use Storage;
use Config;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 11:37
 */
class AuthRuleRepository
{
    protected $auth_rule;

    public function __construct(AdminAuthRule $auth_rule)
    {
        $this->auth_rule = $auth_rule;
    }

    //列表
    public function lists($request)
    {
        $where = 1;
        if ($request->key) {
            $where = 'title like \'%' . $request->key . '%\'';
        }
        return $this->auth_rule->whereRaw($where)->orderBy('sort_order', 'desc')->orderBy('id', 'desc')->paginate($request->limit)->toArray();
    }

    //保存数据
    public function saveData($request, $id = 0)
    {
        if ($id) {
            $result = $this->auth_rule->where('id', $id)->update($request->all());
        } else {
            $result = $this->auth_rule->create($request->all());
            $id = $result->toArray()['id'];
        }
        if (!$result) {
            return resultInfo('编辑失败', 0);
        }
        return resultInfo('编辑成功', 1, $id);
    }

    public function info($id)
    {
        return $this->auth_rule->where('id', $id)->first();
    }

    //权限树
    public function tree()
    {
        $this->auth_rule->select()->get();
    }


    //删除
    public function destroy($id)
    {
        if (!$id) {
            return resultInfo('参数错误', 0);
        }
        $itme = $this->auth_rule->whereIn('parent_id', $id)->count();
        if ($itme) {
            return resultInfo('删除失败：分类下级还存有分类', 0);
        }
        $result = $this->auth_rule->destroy($id);
        if (!$result) {
            return resultInfo('删除失败', 0);
        }
        return resultInfo('删除成功', 1, $id);
    }

}