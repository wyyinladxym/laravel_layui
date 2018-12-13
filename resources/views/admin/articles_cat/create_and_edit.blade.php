@extends('admin.layouts.master')

@section('title', '编辑分类')

@section('content')
    <form class="layui-form linksAdd" id="submit-form">
        <div class="layui-form-item">
            <label class="layui-form-label">分类名称</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input" name="cat_name" value="{{$data['cat_name'] or ''}}"
                       lay-verify="required" placeholder="请输入分类名称"/>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">上级分类</label>
            <div class="layui-input-block">
                <select name="parent_id" lay-search>
                    <option value="0">顶级分类</option>
                    @foreach ($cat_tree as $val)
                        <option value="{{$val['id']}}" {{isset($data['parent_id']) && $data['parent_id'] == $val['id'] ? 'selected' : ''}} >{{$val['html']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否显示</label>
            <div class="layui-input-block">
                <input type="radio" name="is_show" value="0" title="隐藏"
                       lay-verify="required" {{isset($data['is_show']) && $data['is_show'] == 0 ? 'checked' : ''}}>
                <input type="radio" name="is_show" value="1" title="显示"
                       lay-verify="required" {{isset($data['is_show']) && $data['is_show'] == 1 ? 'checked' : ''}}>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">导航显示</label>
            <div class="layui-input-block">
                <input type="radio" name="show_in_nav" value="0" title="隐藏"
                       lay-verify="required" {{isset($data['show_in_nav']) && $data['show_in_nav'] == 0 ? 'checked' : ''}}>
                <input type="radio" name="show_in_nav" value="1" title="显示"
                       lay-verify="required" {{isset($data['show_in_nav']) && $data['show_in_nav'] == 1 ? 'checked' : ''}}>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">分类排序</label>
            <div class="layui-input-block">
                <input type="text" class="layui-input" name="sort_order" value="{{$data['sort_order'] or 0}}"
                       lay-verify="required|number" placeholder="数值排序越大越靠前"/>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">分类描述</label>
            <div class="layui-input-block">
                <textarea name="cat_desc" placeholder="请输入分类描述"
                          class="layui-textarea">{{$data['cat_desc'] or ''}}</textarea>
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
