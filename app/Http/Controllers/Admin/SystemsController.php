<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SystemsController extends Controller {

	public function __construct()
	{

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
