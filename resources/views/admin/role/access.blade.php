@extends('admin.layouts.master')

@section('title', '编辑角色权限')

@section('content')
    <form class="layui-form layui-fluid" id="submit-form">
        @foreach( $auth_rule as $value )
            <div class="layui-row layui-text layui-col-space10">
                <div class="layui-col-xs12">
                    <input type="checkbox" name="rule_id[]" value="{{$value['id']}}" title="{{$value['title']}}"
                           data-pid="{{$value['parent_id']}}"
                           lay-skin="primary" {{in_array($value['id'], $access) ? 'checked' : ''}} >
                </div>
                @if( !empty($value['children']) )
                    @foreach( $value['children'] as $val )
                        <div class="layui-col-xs12 layui-col-lg2 layui-col-sm3 layui-col-md2">
                            &nbsp;|---- <input type="checkbox" name="rule_id[]" value="{{$val['id']}}"
                                               data-pid="{{$val['parent_id']}}"
                                               title="{{$val['title']}}"
                                               lay-skin="primary" {{in_array($val['id'], $access) ? 'checked' : ''}} >
                            @if( !empty($val['children']) )
                                @foreach( $val['children'] as $vo )
                                    <div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        |---- <input type="checkbox" name="rule_id[]" value="{{$vo['id']}}"
                                                     data-pid="{{$vo['parent_id']}}"
                                                     title="{{$vo['title']}}"
                                                     lay-skin="primary" {{in_array($vo['id'], $access) ? 'checked' : ''}} >
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
        <div class="layui-form-item layui-row layui-col-xs12">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-sm" lay-submit="" lay-filter="submitForm">确定</button>
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

            form.on("submit(submitForm)", function (data) {
                //弹出loading
                var index = top.layer.msg('数据提交中，请稍候', {icon: 16, time: false, shade: 0.8});
                // 实际使用时的提交信息
                $.post("{{url('admin/role/access',[$role_id])}}", data.field, function (res) {
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

            form.on('checkbox', function (data) {
                var pid = $(data.elem).attr('data-pid');
                var id = data.value;
                var check = data.elem.checked;
                operation(id, pid, check);
                form.render(); //重新渲染
            });


            //
            function operation(id, pid, check, i = 0) {
                var brother_num = $("input[data-pid=" + pid + "]:checked").length; //已选中同级兄弟元素个数
                var epid = $("input[value=" + pid + "]").attr('data-pid');
                if (check) {
                    i || $("input[data-pid=" + id + "]").prop('checked', true); //选中下级元素
                    $("input[value=" + pid + "]").prop('checked', true); //选中上级
                    if (epid) {
                        operation(pid, epid, check, ++i);
                    }
                } else {
                    if (brother_num) {
                        $("input[data-pid=" + id + "]").prop('checked', false); //取消选中下级元素
                    } else {

                        i || $("input[data-pid=" + id + "]").prop('checked', false); //取消选中下级元素
                        i || $("input[value=" + pid + "]").prop('checked', false); //取消选中上级
                    }
                }
            }

        })
    </script>
@endsection
