@extends('admin.layouts.master')

@section('title', '编辑品牌')

@section('content')
    <form class="layui-form layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg4" id="submit-form">
        <div class="layui-form-item">
            <label class="layui-form-label">品牌LOGO</label>
            <div class="layui-upload-list thumbBox">
                <img class="layui-upload-img thumbImg" src="{{$data['brand_logo'] or ''}}">
            </div>
            <button type="button" class="layui-btn layui-btn-sm layui-hide" id="upload">上传</button>
            <input type="hidden" name="brand_logo" value="{{$data['brand_logo'] or ''}}"/>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">品牌名称</label>
            <div class="layui-input-block">
                <input type="text" name="brand_name" value="{{$data['brand_name'] or ''}}" class="layui-input"
                       lay-verify="required" placeholder="请输入品牌名称">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="text" name="sort_order" value="{{$data['sort_order'] or 0}}" class="layui-input"
                       lay-verify="required|number"
                       placeholder="数值排序越大越靠前">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-sm" lay-submit="" lay-filter="addData">确定</button>
                <button type="reset" class="layui-btn layui-btn-sm layui-btn-primary">取消</button>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        layui.use(['form', 'layer', 'upload'], function () {
            var form = layui.form
            layer = parent.layer === undefined ? layui.layer : top.layer,
                upload = layui.upload,
                $ = layui.jquery;


            form.on("submit(addData)", function (data) {
                //弹出loading
                var index = top.layer.msg('数据提交中，请稍候', {icon: 16, time: false, shade: 0.8});
                // 实际使用时的提交信息
                $.post("{{$sub_url}}", $('#submit-form').serialize(), function (res) {
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

            //上传缩略图
            upload.render({
                elem: '.thumbBox',
                size: 1024,
                field: 'file_brand_logo',
                url: '{{url('admin/brands/upload-logo')}}',
                method: "post",
                choose: function (obj) {
                    //预读本地文件，如果是多文件，则会遍历。(不支持ie8/9)
                    obj.preview(function (index, file, result) {
                        $('.thumbImg').attr('src', result);
                        $('.thumbBox').css("background", "#fff");
                    });
                },
                done: function (res, index, upload) {
                    if (res.status === 0) {
                        layer.msg(res.msg, {icon: 2});
                        return false;
                    }
                    $('.thumbImg').attr('src', res.data);
                    $('.thumbBox').css("background", "#fff");
                    $('input[name="brand_logo"]').val(res.data);
                }
            });
        })
    </script>
@endsection
