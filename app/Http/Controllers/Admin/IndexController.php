<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        return view('admin.index.index');
    }

    public function main()
    {
        //服务器信息
        $info = array(
            '操作系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
            '主机名'=>$_SERVER['SERVER_NAME'],
            'WEB服务端口'=>$_SERVER['SERVER_PORT'],
            '网站文档目录'=>$_SERVER["DOCUMENT_ROOT"],
            '浏览器信息'=>substr($_SERVER['HTTP_USER_AGENT'], 0, 40),
            '通信协议'=>$_SERVER['SERVER_PROTOCOL'],
            '请求方法'=>$_SERVER['REQUEST_METHOD'],
            '上传附件限制'=>ini_get('upload_max_filesize'),
            '执行时间限制'=>ini_get('max_execution_time').'秒',
            '服务器时间'=>date("Y年n月j日 H:i:s"),
            '北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            '用户的IP地址'=>$_SERVER['REMOTE_ADDR'],
            '剩余空间'=>round((disk_free_space(".")/(1024*1024)),2).'M',
        );
        return view('admin.index.main', ['info' => $info]);
    }

    public function navs()
    {
        $data = array(
            'contentManagement' =>
                array(
                    0 =>
                        array(
                            'title' => '品牌',
                            'icon' => '&#xe66c;',
                            'href' => url('admin/brands/index'),
                            'spread' => false,
                        ),
                    1 =>
                        array(
                            'title' => '轮播图',
                            'icon' => '&#xe634;',
                            'href' => url('admin/ads/index'),
                            'spread' => false,
                        ),
                    2 =>
                        array(
                            'title' => '文章分类',
                            'icon' => '&#xe630;',
                            'href' => url('admin/articles-cat/index'),
                            'spread' => false,
                        ),
                    3 =>
                        array(
                            'title' => '文章列表',
                            'icon' => 'icon-text',
                            'href' => url('admin/articles/index'),
                            'spread' => false,
                        ),
                    4 =>
                        array(
                            'title' => '权限管理',
                            'icon' => 'icon-text',
                            'href' => url('admin/auth-rule/index'),
                            'spread' => false,
                        ),
                    5 =>
                        array(
                            'title' => '角色管理',
                            'icon' => 'icon-text',
                            'href' => url('admin/role/index'),
                            'spread' => false,
                        ),
                ),
            'memberCenter' =>
                array(
                    0 =>
                        array(
                            'title' => '用户中心',
                            'icon' => '&#xe612;',
                            'href' => url('admin/users/index'),
                            'spread' => false,
                        )
                ),
            'systemeSttings' =>
                array(
                    0 =>
                        array(
                            'title' => '系统基本参数',
                            'icon' => '&#xe631;',
                            'href' => url('admin/systems/index'),
                            'spread' => false,
                        ),
                    1 =>
                        array(
                            'title' => '管理员账号',
                            'icon' => '&#xe613;',
                            'href' => url('admin/admins/index'),
                            'spread' => false,
                        ),
                    2 =>
                        array(
                            'title' => '系统日志',
                            'icon' => 'icon-log',
                            'href' => url('admin/systems/logs'),
                            'spread' => false,
                        )
                )
        );
        return $data;
    }

}
