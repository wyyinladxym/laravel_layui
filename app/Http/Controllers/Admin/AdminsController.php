<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;
use App\Repositories\AdminRepository;
use App\Repositories\RoleRepository;


class AdminsController extends BaseController
{
    // 任务资源库的实例。
    protected $admin;
    protected $role;

    public function __construct(AdminRepository $admin, RoleRepository $role )
    {
        parent::__construct();
        $this->admin = $admin;
        $this->role = $role;
    }

    public function index()
    {
        return view('admin.admins.index');
    }

    public function lists(Request $request)
    {
        $data = $this->admin->lists($request);
        return resultList($data['data'], $data['total']);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'username' => 'required|alpha_dash|max:20',
                'password' => 'required|alpha_dash',
                'role_id' => 'integer'
            ]);
            if (!$request->admin_pic) {
                $request->offsetSet('admin_pic', '/images/admin/logo.png');
            }
            return $this->admin->saveData($request);
        }
        $result['sub_url'] = $request->url();
        $result['role_data'] = $this->role->getData();
        return view('admin.admins.create_and_edit', $result);
    }

    public function edit(Request $request, $id)
    {
        if (!$id) {
            abort(404);
        }
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'username' => 'required|alpha_dash|max:20',
                'password' => 'alpha_dash',
                'role_id' => 'integer'
            ]);
            if (!$request->admin_pic) {
                $request->offsetSet('admin_pic', '/images/admin/logo.png');
            }
            return $this->admin->saveData($request, $id);
        }
        $result['data'] = $this->admin->info($id);
        $result['sub_url'] = $request->url();
        $result['role_data'] = $this->role->getData();
        return view('admin.admins.create_and_edit', $result);
    }

    //编辑状态
    public function editRow(Request $request, $id)
    {
        if (!$id) {
            return resultInfo('参数错误', 0);
        }
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'status' => 'required|integer',
            ]);
            $edit_data = $request->all();
            if (count($edit_data) != 1 || !isset($edit_data['status'])) {
                return resultInfo('非法数据', 0);
            }
            return $this->admin->saveData($request, $id);
        }
    }

    //删除
    public function destroy(Request $request)
    {
        return $this->admin->destroy($request->id);
    }

}
