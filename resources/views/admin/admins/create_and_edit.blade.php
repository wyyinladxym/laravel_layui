@extends('admin.layouts.master')

@section('title', '管理员')

@section('content')
    <form class="layui-form layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg4" id="submit-form">
        <div class="layui-form-item">
            <label class="layui-form-label">账号</label>
            <div class="layui-input-block">
                <input type="text" name="username" value="{{$data['username'] or ''}}" class="layui-input"
                       lay-verify="required|username" autocomplete="off" placeholder="请输入账号">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
                <input type="password" name="password" class="layui-input"
                       {{isset($data['password']) ? '' : 'lay-verify=required|pass'}}  autocomplete="off"
                       placeholder="请输入密码">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">角色</label>
            <div class="layui-input-block">
                <select name="role_id" lay-verify="required" lay-search>
                    <option value="">请选择角色</option>
                    @foreach($role_data  as $role)
                        <option value="{{$role['id']}}" {{isset($data['role_id'] ) && $data['role_id'] == $role['id'] ? 'selected' : ''}}>{{$role['role_name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">真实姓名</label>
            <div class="layui-input-block">
                <input type="text" name="real_name" value="{{$data['real_name'] or ''}}" class="layui-input" disabled>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">手机号码</label>
            <div class="layui-input-block">
                <input type="text" name="phone" value="{{$data['phone'] or ''}}" class="layui-input" disabled>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-block">
                <input type="text" name="email" value="{{$data['email'] or ''}}" class="layui-input" disabled>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status" value="1" lay-text="正常|冻结"
                       {{isset($data['status']) && $data['status'] ? 'checked' : ''}} lay-skin="switch" >
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-sm" lay-submit="" lay-filter="submitForm">确定</button>
                <button type="reset" class="layui-btn layui-btn-sm layui-btn-primary">取消</button>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        layui.use(['form', 'layer'], function () {
            var form = layui.form
            layer = parent.layer === undefined ? layui.layer : top.layer,
                $ = layui.jquery;
            //自定义表单验证
            form.verify({
                username: [
                    /^[a-zA-Z0-9_-]{4,16}$/
                    , '账号必须4到16位（字母，数字，下划线，减号）'
                ]
                , pass: [
                    /^[\S]{6,12}$/
                    , '密码必须6到12位，且不能出现空格'
                ]
            });

            form.on("submit(submitForm)", function (data) {
                if (!data.field.status) {
                    data.field.status = 0
                }
                //弹出loading
                var index = top.layer.msg('数据提交中，请稍候', {icon: 16, time: false, shade: 0.8});
                // 实际使用时的提交信息
                $.post("{{$sub_url}}", data.field, function (res) {
                    if (res.status === 0) {
                        layer.msg(res.msg, {icon: 2});
                        return false;
                    }
                    top.layer.close(index);
                    top.layer.msg(res.msg, {icon: 1});
                    layer.closeAll("iframe");
                    //刷新父页面
                    parent.location.reload();
                }).error(function (res) {
                    top.layer.close(index);
                    top.layer.msg('操作失败', {icon: 2});
                })
                return false;
            })
        })
    </script>
@endsection
