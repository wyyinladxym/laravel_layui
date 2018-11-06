<?php namespace App\Repositories;

use App\Models\AdminRole;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 11:37
 */
class RoleRepository
{
    protected $role;

    public function __construct(AdminRole $role)
    {
        $this->role = $role;
    }

    //列表
    public function lists($request)
    {
        $where = 1;
        if ($request->key) {
            $where = 'role_name like \'%' . $request->key . '%\'';
        }
        return $this->role->whereRaw($where)->orderBy('id', 'asc')->paginate($request->limit)->toArray();
    }

    //保存数据
    public function saveData($request, $id = 0)
    {
        if ($id) {
            $result = $this->role->where('id', $id)->update($request->all());
        } else {
            $result = $this->role->create($request->all());
            $id = $result->toArray()['id'];
        }
        if (!$result) {
            return resultInfo('编辑失败', 0);
        }
        return resultInfo('编辑成功', 1, $id);
    }

    public function info($id)
    {
        return $this->role->where('id', $id)->first();
    }

    //删除
    public function destroy($id)
    {
        if (!$id) {
            return resultInfo('参数错误', 0);
        }
        $result = $this->role->destroy($id);
        if (!$result) {
            return resultInfo('删除失败', 0);
        }
        return resultInfo('删除成功', 1, $id);
    }

}