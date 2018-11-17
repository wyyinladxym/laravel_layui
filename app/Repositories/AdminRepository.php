<?php namespace App\Repositories;

use App\Models\Admin;
use App\Models\AdminRole;
use Cache;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 11:37
 */
class AdminRepository
{
    protected $admin;
    protected $role;

    public function __construct(Admin $admin, AdminRole $role)
    {
        $this->admin = $admin;
        $this->role = $role;
    }

    //列表
    public function lists($request)
    {
        $where = 1;
        if ($request->key) {
            $where = 'username like \'%' . $request->key . '%\' OR phone like \'%' . $request->key . '%\'';
        }
        return $this->admin->join('admin_role', 'admins.role_id', '=', 'admin_role.id')
            ->select('admins.*', 'admin_role.role_name')->whereRaw($where)
            ->orderBy('id', 'asc')->paginate($request->limit)->toArray();
    }

    //保存数据
    public function saveData($request, $id = 0)
    {
        if ($request->password) {
            $request->offsetSet('password', md6($request->password));
        } else {
            unset($request['password']);
        }
        if ($id) {
            $result = $this->admin->where('id', $id)->update($request->all());
        } else {
            $result = $this->admin->create($request->all());
            $id = $result->toArray()['id'];
        }
        if (!$result) {
            return resultInfo('编辑失败', 0);
        }
        return resultInfo('编辑成功', 1, $id);
    }

    public function info($id)
    {
        return $this->admin->where('id', $id)->first();
    }

    //删除
    public function destroy($id)
    {
        if (!$id) {
            return resultInfo('参数错误', 0);
        }
        $result = $this->admin->destroy($id);
        if (!$result) {
            return resultInfo('删除失败', 0);
        }
        return resultInfo('删除成功', 1, $id);
    }

    //管理员登录
    public function login($data = [])
    {
        if (empty($data)) {
            return resultInfo('登录失败', '0');
        }
        $username = trim($data['username']);
        $password = md6($data['password']);
        $info = $this->admin->select('id', 'username', 'role_id', 'status', 'admin_pic')->where('username', $username)->where('password', $password)->first();
        if (!$info) {
            return resultInfo('账号或密码错误', 0);
        }
        $info = $info->toArray();
        if ($info['status'] == 0) {
            return resultInfo('账号已冻结', 0);
        }
        session(['adminUser' => $info]);
        Cache::forget('cache_menu_' . $info['role_id']);
        return resultInfo('登录成功', 1, $info['id'], url('admin'));
    }

    //管理员权限
    public function admin_rule($id)
    {
        return $this->admin->first($id);

    }

    //获取后台菜单并缓存
    public function adminMenu($role_id)
    {
        if (Cache::has('cache_menu_' . $role_id)) {
            return Cache::get('cache_menu_' . $role_id);
        }
        $role = $this->role->find($role_id);
        $items = $role->authRules()->select('id', 'parent_id', 'title', 'rule_val', 'menu_url', 'icon')->where('type', 0)
            ->orderBy('sort_order', 'desc')->orderBy('id', 'desc')->get()->toArray();
        $tree_data = getTree($items);
        Cache::put('cache_menu_' . $role_id, $tree_data, 0); //缓存菜单60分钟
        return $tree_data;
    }

}