<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class BaseController extends Controller
{
    protected $admin_user = [];


    public function __construct()
    {
        //权限中间件
        $this->middleware('adminUser');

        $this->admin_user = session('adminUser');
    }

}