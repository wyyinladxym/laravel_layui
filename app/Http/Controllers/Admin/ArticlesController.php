<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;

class ArticlesController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.articles.index');
    }

    public function lists()
    {
        $data = '{
                "code": 0,
                "msg": "",
                "count": 15,
                "data": [
                    {
                        "newsId": "1",
                        "newsName": "css3用transition实现边框动画效果",
                        "newsAuthor": "驊驊龔頾",
                        "abstract": "css3用transition实现边框动画效果css3用transition实现边框动画效果",
                        "newsStatus": "0",
                        "newsImg":"../../images/userface1.jpg",
                        "newsLook": "开放浏览",
                        "newsTop": "",
                        "newsTime": "2017-04-14 00:00:00",
                        "content" : "css3用transition实现边框动画效果<img src=\'../../images/userface1.jpg\' alt=\'文章内容图片\'>css3用transition实现边框动画效果css3用transition实现边框动画效果"
                    },
                    {
                        "newsId": "2",
                        "newsName": "自定义的模块名称可以包含/吗",
                        "newsAuthor": "驊驊龔頾",
                        "abstract": "自定义的模块名称可以包含/吗自定义的模块名称可以包含/吗",
                        "newsStatus": "1",
                        "newsImg":"../../images/userface2.jpg",
                        "newsLook": "私密浏览",
                        "newsTop": "checked",
                        "newsTime": "2017-04-14 00:00:00",
                        "content" : "自定义的模块名称可以包含自定义的模块名称可<img src=\'../../images/userface2.jpg\' alt=\'文章内容图片\'>以包含自定义的模块名称可以包含自定义的模块名称可以包含"
                    },
                    {
                        "newsId": "3",
                        "newsName": "layui.tree如何ajax加载二级菜单",
                        "newsAuthor": "admin",
                        "abstract": "layui.tree如何ajax加载二级菜单layui.tree如何ajax加载二级菜单",
                        "newsStatus": "2",
                        "newsImg":"../../images/userface3.jpg",
                        "newsLook": "开放浏览",
                        "newsTop": "checked",
                        "newsTime": "2017-04-14 00:00:00",
                        "content" : "layui.tree如何ajax加载二级菜单layui.tree如何<img src=\'../../images/userface3.jpg\' alt=\'文章内容图片\'>ajax加载二级菜单layui.tree如何ajax加载二级菜单"
                    },
                    {
                        "newsId": "4",
                        "newsName": "layui.upload如何带参数？像jq的data:{}那样",
                        "newsAuthor": "admin",
                        "abstract": "layui.upload如何带参数？像jq的data:{}那样layui.upload如何带参数？像jq的data:{}那样",
                        "newsStatus": "0",
                        "newsImg":"../../images/userface4.jpg",
                        "newsLook": "私密浏览",
                        "newsTop": "",
                        "newsTime": "2017-04-14 00:00:00",
                        "content" : "layui.upload如何带参数？像jq的data:{}那样layui.upload如何带参数？像jq的data:{}那样layui.upload如何带参数？像jq的data:{}那样"
                    },
                    {
                        "newsId": "5",
                        "newsName": "表单元素长度应该怎么调整才美观",
                        "newsAuthor": "驊驊龔頾",
                        "abstract": "表单元素长度应该怎么调整才美观表单元素长度应该怎么调整才美观",
                        "newsStatus": "1",
                        "newsImg":"../../images/userface5.jpg",
                        "newsLook": "开放浏览",
                        "newsTop": "checked",
                        "newsTime": "2017-04-14 00:00:00",
                        "content" : "表单元素长度应该怎么调整才美观表单元素长度应该怎么调整才美观表单元素长度应该怎么调整才美观表单元素长度应该怎么调整才美观"
                    },
                    {
                        "newsId": "6",
                        "newsName": "layui 利用ajax冲获取到json 数据后 怎样进行渲染",
                        "newsAuthor": "admin",
                        "abstract": "layui 利用ajax冲获取到json 数据后 怎样进行渲染layui 利用ajax冲获取到json 数据后 怎样进行渲染",
                        "newsStatus": "0",
                        "newsImg":"../../images/userface1.jpg",
                        "newsLook": "私密浏览",
                        "newsTop": "checked",
                        "newsTime": "2017-04-14 00:00:00",
                        "content" : "layui 利用ajax冲获取到json 数据后 怎样进行渲染layui 利用ajax冲获取到json 数据后 怎样进行渲染layui 利用ajax冲获取到json 数据后 怎样进行渲染"
                    },
                    {
                        "newsId": "7",
                        "newsName": "微信页面中富文本编辑器LayEdit无法使用",
                        "newsAuthor": "驊驊龔頾",
                        "abstract": "微信页面中富文本编辑器LayEdit无法使用微信页面中富文本编辑器LayEdit无法使用",
                        "newsStatus": "1",
                        "newsImg":"../../images/userface2.jpg",
                        "newsLook": "开放浏览",
                        "newsTop": "",
                        "newsTime": "2017-04-14 00:00:00",
                        "content" : "微信页面中富文本编辑器LayEdit无法使用微信页面中富文本编辑器LayEdit无法使用微信页面中富文本编辑器LayEdit无法使用"
                    },
                    {
                        "newsId": "8",
                        "newsName": "layui 什么时候发布新的版本呀",
                        "newsAuthor": "驊驊龔頾",
                        "abstract": "layui 什么时候发布新的版本呀layui 什么时候发布新的版本呀",
                        "newsStatus": "2",
                        "newsImg":"../../images/userface3.jpg",
                        "newsLook": "私密浏览",
                        "newsTop": "checked",
                        "newsTime": "2017-04-14 00:00:00",
                        "content" : "layui 什么时候发布新的版本呀layui 什么时候发布新的版本呀layui 什么时候发布新的版本呀layui 什么时候发布新的版本呀"
                    },
                    {
                        "newsId": "9",
                        "newsName": "layui上传组件不支持上传前的图片预览嘛？",
                        "newsAuthor": "admin",
                        "abstract": "layui上传组件不支持上传前的图片预览嘛？layui上传组件不支持上传前的图片预览嘛？",
                        "newsStatus": "2",
                        "newsImg":"../../images/userface4.jpg",
                        "newsLook": "私密浏览",
                        "newsTop": "checked",
                        "newsTime": "2017-04-14 00:00:00",
                        "content" : "layui上传组件不支持上传前的图片预览嘛？layui上传组件不支持上传前的图片预览嘛？layui上传组件不支持上传前的图片预览嘛？"
                    },
                    {
                        "newsId": "10",
                        "newsName": "关于layer.confirm点击无法关闭的疑惑",
                        "newsAuthor": "admin",
                        "abstract": "关于layer.confirm点击无法关闭的疑惑关于layer.confirm点击无法关闭的疑惑",
                        "newsStatus": "1",
                        "newsImg":"../../images/userface5.jpg",
                        "newsLook": "开放浏览",
                        "newsTop": "",
                        "newsTime": "2017-04-14 00:00:00",
                        "content" : "关于layer.confirm点击无法关闭的疑惑关于layer.confirm点击无法关闭的疑惑关于layer.confirm点击无法关闭的疑惑"
                    },
                    {
                        "newsId": "11",
                        "newsName": "layui form表单提交成功如何拿取返回值",
                        "newsAuthor": "驊驊龔頾",
                        "abstract": "layui form表单提交成功如何拿取返回值layui form表单提交成功如何拿取返回值",
                        "newsStatus": "2",
                        "newsImg":"../../images/userface1.jpg",
                        "newsLook": "私密浏览",
                        "newsTop": "checked",
                        "newsTime": "2017-04-14 00:00:00",
                        "content" : "layui form表单提交成功如何拿取返回值layui form表单提交成功如何拿取返回值layui form表单提交成功如何拿取返回值"
                    },
                    {
                        "newsId": "12",
                        "newsName": "layer mobileV2.0 yes回调函数无法用？",
                        "newsAuthor": "驊驊龔頾",
                        "abstract": "layer mobileV2.0 yes回调函数无法用？layer mobileV2.0 yes回调函数无法用？",
                        "newsStatus": "1",
                        "newsImg":"../../images/userface2.jpg",
                        "newsLook": "开放浏览",
                        "newsTop": "checked",
                        "newsTime": "2017-04-14 00:00:00",
                        "content" : "layer mobileV2.0 yes回调函数无法用layer mobileV2.0 yes回调函数无法用layer mobileV2.0 yes回调函数无法用"
                    },
                    {
                        "newsId": "13",
                        "newsName": "关于layer中自带的btn回调弹层页面的内容",
                        "newsAuthor": "admin",
                        "abstract": "关于layer中自带的btn回调弹层页面的内容关于layer中自带的btn回调弹层页面的内容",
                        "newsStatus": "1",
                        "newsImg":"../../images/userface3.jpg",
                        "newsLook": "私密浏览",
                        "newsTop": "",
                        "newsTime": "2017-04-14 00:00:00",
                        "content" : "关于layer中自带的btn回调弹层页面的内容关于layer中自带的btn回调弹层页面的内容关于layer中自带的btn回调弹层页面的内容"
                    },
                    {
                        "newsId": "14",
                        "newsName": "被编辑器 layedit 图片上传搞崩溃了",
                        "newsAuthor": "驊驊龔頾",
                        "abstract": "被编辑器 layedit 图片上传搞崩溃了被编辑器 layedit 图片上传搞崩溃了",
                        "newsStatus": "0",
                        "newsImg":"../../images/userface4.jpg",
                        "newsLook": "私密浏览",
                        "newsTop": "checked",
                        "newsTime": "2017-04-14 00:00:00",
                        "content" : "被编辑器 layedit 图片上传搞崩溃了被编辑器 layedit 图片上传搞崩溃了被编辑器 layedit 图片上传搞崩溃了"
                    },
                    {
                        "newsId": "15",
                        "newsName": "element.tabChange()方法运行了，但是页面并没有产生效果",
                        "newsAuthor": "驊驊龔頾",
                        "abstract": "element.tabChange()方法运行了，但是页面并没有产生效果element.tabChange()方法运行了，但是页面并没有产生效果",
                        "newsStatus": "2",
                        "newsImg":"../../images/userface5.jpg",
                        "newsLook": "开放浏览",
                        "newsTop": "checked",
                        "newsTime": "2017-04-14 00:00:00",
                        "content" : "element.tabChange()方法运行了，但是页面并没有产生效果element.tabChange()方法运行了，但是页面并没有产生效果"
                    }
                ]
                }';
        return json_decode($data, true);
    }

    public function create()
    {
        return view('admin.articles.create');
    }
}
