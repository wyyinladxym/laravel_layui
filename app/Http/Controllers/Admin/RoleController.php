<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\RoleRepository;


class RoleController extends Controller
{

    // 任务资源库的实例。
    protected $role;

    public function __construct(RoleRepository $role)
    {
        $this->role = $role;
    }

    public function index()
    {
        return view('admin.role.index');
    }

    public function lists(Request $request)
    {
        $data = $this->role->lists($request);
        return resultList($data['data'], $data['total']);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'role_name' => 'required|max:20',
                'remark' => 'max:255',
            ]);
            return $this->role->saveData($request);
        }
        $result['sub_url'] = $request->url();
        return view('admin.role.create_and_edit', $result);
    }

    public function edit(Request $request, $id)
    {
        if (!$id) {
            abort(404);
        }
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'role_name' => 'required|max:20',
                'remark' => 'max:255',
            ]);
            return $this->role->saveData($request, $id);
        }
        $result['data'] = $this->role->info($id);
        $result['sub_url'] = $request->url();
        return view('admin.role.create_and_edit', $result);
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
            return $this->role->saveData($request, $id);
        }
    }

    //权限关系编辑
    public function access(Request $request, $id)
    {
        if (!$id) {
            abort(404);
        }
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'status' => 'required|integer',
            ]);
            $edit_data = $request->all();
            if (count($edit_data) != 1 || !isset($edit_data['status'])) {
                return resultInfo('非法数据', 0);
            }
            return $this->role->saveData($request, $id);
        }

        return view('admin.role.access');
    }

    //删除
    public function destroy(Request $request)
    {
        return $this->role->destroy($request->id);
    }

}
