@extends('admin.layouts.master')

@section('title', '编辑角色')

@section('content')
    <form class="layui-form layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg4"  id="submit-form">
        <div class="layui-form-item">
            <label class="layui-form-label">角色名称</label>
            <div class="layui-input-block">
                <input type="text" name="role_name" value="{{$data['role_name'] or ''}}" class="layui-input"
                       lay-verify="required" placeholder="请输入角色名称">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">备注</label>
            <div class="layui-input-block">
                <textarea name="remark"
                          placeholder="请输入内容" class="layui-textarea ">{{$data['remark'] or ''}}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status" value="1" lay-text="正常|冻结"
                       {{isset($data['status']) && $data['status'] ? 'checked' : ''}} lay-skin="switch">
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
                })
                return false;
            })
        })
    </script>
@endsection
