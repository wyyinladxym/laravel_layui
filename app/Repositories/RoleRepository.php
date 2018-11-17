<?php namespace App\Repositories;

use App\Models\AdminRole;
use DB;
use Cache;

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

    //获取角色数据
    public function getData()
    {
        return $this->role->orderBy('id', 'asc')->get()->toArray();
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

    //获取角色权限
    public function getRules($id, $row_val = '', $row_key = '')
    {
        $role = $this->role->find($id);
        if ($row_val && $row_key) {
            $result = $role->authRules->lists($row_val, $row_key);
        } elseif ($row_val) {
            $result = $role->authRules->lists($row_val);
        } else {
            $result = $role->authRules->toArray();
        }
        return $result;
    }

    //编辑角色权限
    public function editRules($role_id, $rule_id)
    {
        $role = $this->role->find($role_id);
        $role->authRules()->detach(); //删除该角色全部权限
        $role->authRules()->attach($rule_id); //设置角色权限
        Cache::forget('cache_menu_' . $role_id);
        return resultInfo('操作成功', 1, $role_id);
    }

    //删除
    public function destroy($id)
    {
        if (!$id) {
            return resultInfo('参数错误', 0);
        }
        $id = is_array($id) ? $id : func_get_args();

        if (Db::table('admins')->whereIn('role_id', $id)->count()) {
            return resultInfo('删除失败：删除角色有管理员正在使用');
        }
        $result = $this->role->destroy($id);
        if (!$result) {
            return resultInfo('删除失败', 0);
        }
        Db::table('admin_auth_access')->whereIn('role_id', $id)->delete();
        return resultInfo('删除成功', 1, $id);
    }

}