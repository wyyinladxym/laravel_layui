<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;

class UsersController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.users.index');
    }

    public function create()
    {
        return view('admin.users.create_and_edit');
    }


}
