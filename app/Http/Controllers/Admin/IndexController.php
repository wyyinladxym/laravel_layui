<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;
use Illuminate\Http\Request;
use App\Repositories\AdminRepository;

class IndexController extends BaseController
{
    protected $admin;

    public function __construct(AdminRepository $admin)
    {
        parent::__construct();
        $this->admin = $admin;
    }

    //首页
    public function index()
    {
        //获取菜单
        $result['admin_menu'] = $this->admin->adminMenu($this->admin_user['role_id']);
        return view('admin.index.index', $result);
    }

    //基本信息
    public function main()
    {
        //服务器信息
        $info = array(
            '操作系统' => PHP_OS,
            '运行环境' => $_SERVER["SERVER_SOFTWARE"],
            '主机名' => $_SERVER['SERVER_NAME'],
            'WEB服务端口' => $_SERVER['SERVER_PORT'],
            '网站文档目录' => $_SERVER["DOCUMENT_ROOT"],
            '浏览器信息' => substr($_SERVER['HTTP_USER_AGENT'], 0, 40),
            '通信协议' => $_SERVER['SERVER_PROTOCOL'],
            '请求方法' => $_SERVER['REQUEST_METHOD'],
            '上传附件限制' => ini_get('upload_max_filesize'),
            '执行时间限制' => ini_get('max_execution_time') . '秒',
            '服务器时间' => date("Y年n月j日 H:i:s"),
            '北京时间' => gmdate("Y年n月j日 H:i:s", time() + 8 * 3600),
            '服务器域名/IP' => $_SERVER['SERVER_NAME'] . ' [ ' . gethostbyname($_SERVER['SERVER_NAME']) . ' ]',
            '用户的IP地址' => $_SERVER['REMOTE_ADDR'],
            '剩余空间' => round((disk_free_space(".") / (1024 * 1024)), 2) . 'M',
        );
        return view('admin.index.main', ['info' => $info]);
    }

    //获取左侧菜单
    public function navs(Request $request, $id)
    {
        $menu_data = $this->admin->adminMenu($this->admin_user['role_id']);
        //默认返回第一组菜单
        if (!$id) {
            return reset($menu_data)['children'];
        }
        //找不到菜单返回空数组
        if (!isset($menu_data[$id])) {
            return [];
        }
        return $menu_data[$id]['children'];
    }

}
