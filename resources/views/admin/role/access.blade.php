@extends('admin.layouts.master')

@section('title', '编辑角色权限')

@section('content')
    <form class="layui-form" style="width:80%;" id="submit-form">
        <div class="layui-form-item layui-row layui-col-xs12">
            <label class="layui-form-label">轮播图</label>
            <div class="layui-upload-list thumbBox mag0 magt3 layui-col-xs8 layui-col-md4">
                <img class="layui-upload-img thumbImg" src="{{$data['ad_pic'] or ''}}">
            </div>
            <button type="button" class="layui-btn layui-btn-sm layui-hide" id="upload">上传</button>
            <input type="hidden" name="ad_pic" value="{{$data['ad_pic'] or ''}}"/>
        </div>
        <div class="layui-form-item layui-row layui-col-xs12">
            <label class="layui-form-label">广告名称</label>
            <div class="layui-input-block">
                <input type="text" name="ad_name" value="{{$data['ad_name'] or ''}}" class="layui-input"
                       lay-verify="required" placeholder="请输入广告名称">
            </div>
        </div>
        <div class="layui-form-item layui-row layui-col-xs12">
            <label class="layui-form-label">跳转地址</label>
            <div class="layui-input-block">
                <input type="text" name="ad_link" value="{{$data['ad_link'] or ''}}" class="layui-input"
                       placeholder="请输入跳转地址">
            </div>
        </div>
        <div class="layui-form-item layui-row layui-col-xs12">
            <label class="layui-form-label">点击量</label>
            <div class="layui-input-inline">
                <input type="text" name="click_count" value="{{$data['click_count'] or 0}}" class="layui-input"
                       placeholder="请输入点击量">
            </div>
        </div>
        <div class="layui-form-item layui-row layui-col-xs12">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input type="text" name="sort_order" value="{{$data['sort_order'] or 0}}" class="layui-input"
                       lay-verify="required|number"
                       placeholder="数值排序越大越靠前">
            </div>
        </div>
        <div class="layui-form-item layui-row layui-col-xs12">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" name="is_show" value="1" lay-text="显示|隐藏"
                       {{isset($data['is_show']) && $data['is_show'] ? 'checked' : ''}} lay-skin="switch">
            </div>
        </div>
        <div class="layui-form-item layui-row layui-col-xs12">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-sm" lay-submit="" lay-filter="addUser">确定</button>
                <button type="reset" class="layui-btn layui-btn-sm layui-btn-primary">取消</button>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        layui.use(['form', 'layer', 'tree'], function () {
            var form = layui.form
            layer = parent.layer === undefined ? layui.layer : top.layer,
                $ = layui.jquery;

            //设置ajax请求表头添加X-CSRF-TOKEN
            start_token();

            form.on("submit(submitForm)", function (data) {
                if (!data.field.status) {
                    data.field.status = 0
                }
                //弹出loading
                var index = top.layer.msg('数据提交中，请稍候', {icon: 16, time: false, shade: 0.8});
                // 实际使用时的提交信息
                $.post("", data.field, function (res) {
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
