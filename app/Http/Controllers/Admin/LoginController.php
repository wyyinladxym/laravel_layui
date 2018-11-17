<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AdminRepository;

class LoginController extends Controller
{
    // 任务资源库的实例。
    protected $admin;

    public function __construct(AdminRepository $admin)
    {
        $this->admin = $admin;
    }

    public function index()
    {
        return view('admin.index.login');
    }

    //登录
    public function login(Request $request)
    {
        return $this->admin->login($request->all());
    }

    //退出登录
    public function loginOut(Request $request)
    {
        $request->session()->forget('adminUser');
        return redirect('admin/login');
    }

}
