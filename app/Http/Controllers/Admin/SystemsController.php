<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;

class SystemsController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.systems.index');
    }

    //系统日志
    public function logs()
    {
        return view('admin.systems.logs');
    }

}
