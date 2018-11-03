@extends('admin.layouts.master')

@section('title', '编辑权限')

@section('content')
    <form class="layui-form linksAdd" id="submit-form">
        <div class="layui-form-item">
            <label class="layui-form-label">权限名称</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input" name="title" value="{{$data['title'] or ''}}"
                       lay-verify="required" placeholder="请输入网站名称"/>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限标识</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input" name="rule_val" value="{{$data['rule_val'] or ''}}"
                       lay-verify="required" placeholder="请输入权限值"/>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图标</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input" name="icon" value="{{$data['icon'] or ''}}" placeholder="请输入图标"/>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">上级权限</label>
            <div class="layui-input-block">
                <select name="parent_id" lay-verify="">
                    <option value="0">顶级分类</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input" name="sort_order" value="{{$data['sort_order'] or 0}}"
                       lay-verify="required|number" placeholder="数值排序越大越靠前"/>
            </div>
        </div>
        <div class="layui-form-item">
            <button class="layui-btn layui-block" lay-filter="addData" lay-submit>提交</button>
        </div>
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        layui.use(['form', 'layer', 'upload'], function () {
            var form = layui.form
            layer = parent.layer === undefined ? layui.layer : top.layer,
                $ = layui.jquery;

            //设置ajax请求表头添加X-CSRF-TOKEN
            start_token();

            form.on("submit(addData)", function (data) {
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
                    $(".layui-tab-item.layui-show", parent.document).find("iframe")[0].contentWindow.location.reload();
                })
                return false;
            })
        })
    </script>
@endsection
