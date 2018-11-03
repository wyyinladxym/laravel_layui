<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class UsersController extends Controller {

    public function __construct()
    {

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
