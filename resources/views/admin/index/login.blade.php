<!DOCTYPE html>
<html class="loginHtml">
<head>
    <meta charset="utf-8">
    <title>登录</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/favicon.ico">
    <link rel="stylesheet" href="{{asset('/frame/layui/css/layui.css')}}" media="all"/>
    <link rel="stylesheet" href="{{asset('/css/admin/public.css')}}" media="all"/>
</head>
<body class="loginBody">
<form class="layui-form">
    <div class="login_face"><img src="/images/admin/logo.png" class="userAvatar"></div>
    <div class="layui-form-item input-item">
        <label for="userName">用户名</label>
        <input type="text" name="username" placeholder="请输入用户名" autocomplete="off" id="userName" class="layui-input"
               lay-verify="required|username" lay-verType="tips">
    </div>
    <div class="layui-form-item input-item">
        <label for="password">密码</label>
        <input type="password" name="password" placeholder="请输入密码" autocomplete="off" id="password" class="layui-input"
               lay-verify="required|pass" lay-verType="tips">
    </div>
    {{--<div class="layui-form-item input-item" id="imgCode">--}}
        {{--<label for="code">验证码</label>--}}
        {{--<input type="text" name="code" placeholder="请输入验证码" autocomplete="off" id="code" class="layui-input" lay-verType="tips">--}}
        {{--<img src="">--}}
    {{--</div>--}}
    <div class="layui-form-item">
        <button class="layui-btn layui-block" lay-filter="login" lay-submit>登录</button>
    </div>
</form>
<script type="text/javascript" src="{{asset('/frame/layui/layui.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/admin/cache.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/admin/public.js')}}"></script>
</body>
<script>
    layui.use(['form', 'layer', 'jquery'], function () {
        var form = layui.form,
            layer = parent.layer === undefined ? layui.layer : top.layer
        $ = layui.jquery;

        form.verify({
            username: [
                /^[a-zA-Z0-9_-]{4,16}$/
                , '账号必须4到16位（字母，数字，下划线）'
            ]
            , pass: [
                /^[\S]{6,12}$/
                , '密码必须6到12位，且不能出现空格'
            ]
        });

        //登录按钮
        form.on("submit(login)", function (data) {
            var obj = $(this);
            obj.text("登录中...").attr("disabled", "disabled").addClass("layui-disabled");
            // 实际使用时的提交信息
            $.post("{{url('admin/login')}}", data.field, function (res) {
                if (res.status === 0) {
                    layer.msg(res.msg, {icon: 2});
                    obj.text("登录").removeAttr("disabled").removeClass("layui-disabled");
                    return false;
                }
                layer.msg(res.msg, {icon: 1});
                window.location.href = res.url;
            }).error(function (res) {
                layer.msg('网络错误', {icon: 2});
                obj.text("登录").removeAttr("disabled").removeClass("layui-disabled");
            })
            return false;
        })

        //表单输入效果
        $(".loginBody .input-item").click(function (e) {
            e.stopPropagation();
            $(this).addClass("layui-input-focus").find(".layui-input").focus();
        })
        $(".loginBody .layui-form-item .layui-input").focus(function () {
            $(this).parent().addClass("layui-input-focus");
        })
        $(".loginBody .layui-form-item .layui-input").blur(function () {
            $(this).parent().removeClass("layui-input-focus");
            if ($(this).val() != '') {
                $(this).parent().addClass("layui-input-active");
            } else {
                $(this).parent().removeClass("layui-input-active");
            }
        })
    })
</script>
</html>