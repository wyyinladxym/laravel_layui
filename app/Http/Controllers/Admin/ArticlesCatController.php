<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;


class ArticlesCatController extends Controller {

    public function __construct()
    {

    }

    public function index()
    {
        return view('admin.admins.index');
    }

    //个人资料
    public function info()
    {
        return view('admin.admins.info');
    }

    //修改密码
    public function change_pwd()
    {
        return view('admin.admins.change_pwd');
    }

    public function create(Request $request)
    {
        $user = Admin::find(1);
        var_dump($user);
        if( $request->isMethod('post') ) {
            var_dump($request);

        }
        return view('admin.admins.create');
    }

    public function edit(Request $request)
    {
        return view('admin.admins.edit');
    }


}
