@extends('admin.layouts.master')

@section('title', '权限列表')

@section('content')
    <form class="layui-form">
        <blockquote class="layui-elem-quote quoteBox">
            <form class="layui-form">
                <div class="layui-inline">
                    <div class="layui-input-inline">
                        <input type="text" class="layui-input searchVal" placeholder="请输入搜索的内容"/>
                    </div>
                    <a class="layui-btn search_btn" data-type="reload">搜索</a>
                </div>
                <div class="layui-inline">
                    <a class="layui-btn layui-btn-normal addNews_btn">添加权限</a>
                </div>
                <div class="layui-inline">
                    <a class="layui-btn layui-btn-danger layui-btn-normal delAll_btn">批量删除</a>
                </div>
            </form>
        </blockquote>
        <table id="list" lay-filter="list"></table>

        <!--操作-->
        <script type="text/html" id="listBar">
            <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
            <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
        </script>
    </form>
@endsection

@section('script')
    <script type="text/javascript">

        layui.use(['form', 'layer', 'table', 'laytpl'], function () {
            var form = layui.form
            layer = parent.layer === undefined ? layui.layer : top.layer,
                $ = layui.jquery,
                laytpl = layui.laytpl,
                table = layui.table;

            //设置ajax请求表头添加X-CSRF-TOKEN
            start_token();

            //用户列表
            var tableIns = table.render({
                elem: '#list',
                url: '{{url('admin/auth-rule/lists')}}',
                cellMinWidth: 95,
                page: true,
                height: "full-125",
                limits: [10, 20, 30, 40],
                limit: 15,
                id: "listTable",
                cols: [[
                    {type: 'checkbox', fixed: "left", width: 50},
                    {field: 'title', title: '权限名称', minWidth: 100, align: 'left'},
                    {
                        field: 'rule_val', title: '权限标识', minWidth: 200, align: 'left', templet: function (d) {
                            return '<a class="layui-blue">' + d.rule_val + '</a>';
                        }
                    },
                    {
                        field: 'icon', title: '图标', align: 'center', templet: function (d) {
                            return '<i class="layui-icon" data-icon="' + d.icon + '">' + d.icon + '</i>';
                        }
                    },
                    {field: 'parent_id', title: '上级id', minWidth: 100, align: 'center'},
                    {field: 'sort_order', title: '排序', align: 'center', edit: 'text',},
                    {field: 'updated_at', title: '修改时间', align: 'center', minWidth: 150},
                    {field: 'created_at', title: '创建时间', align: 'center', minWidth: 150},
                    {title: '操作', minWidth: 175, templet: '#listBar', fixed: "right", align: "center"}
                ]]
            });

            //监听单元格编辑
            table.on('edit(list)', function (obj) {
                var value = obj.value //得到修改后的值
                    , data = obj.data //得到所在行所有键值
                    , field = obj.field; //得到字段
                var index = layer.msg('修改中，请稍候', {icon: 16, time: false, shade: 0.8});
                $.post("{{url('admin/auth-rule/edit-row')}}/" + data.id + "", {[field]: value}, function (res) {
                    layer.close(index);
                    if (res.status === 0) {
                        layer.msg(res.msg, {icon: 2});
                        return false;
                    }
                    layer.msg(res.msg, {icon: 1});
                }).error(function () {
                    layer.msg('修改失败', {icon: 2});
                    layer.close(index);
                    return false;
                })
            });

            //搜索
            $(".search_btn").on("click", function () {
                if ($(".searchVal").val() != '') {
                    table.reload("listTable", {
                        page: {
                            curr: 1 //重新从第 1 页开始
                        },
                        where: {
                            key: $(".searchVal").val()  //搜索的关键字
                        }
                    })
                } else {
                    layer.msg("请输入搜索的内容");
                }
            });

            function addData(url) {
                var index = layer.open({
                    title: "编辑",
                    type: 2,
                    area: ["360px", "385px"],
                    content: url,
                    success: function (layero, index) {
                        setTimeout(function () {
                            layer.tips('点击此处返回列表', '.layui-layer-setwin .layui-layer-close', {
                                tips: 3
                            });
                        }, 500)
                    }
                })
            }

            $(".addNews_btn").click(function () {
                addData('{{url('admin/auth-rule/create')}}');
            })

            //批量删除
            $(".delAll_btn").click(function () {
                var checkStatus = table.checkStatus('listTable'),
                    data = checkStatus.data,
                    newsId = [];
                if (data.length > 0) {
                    for (var i in data) {
                        newsId.push(data[i].id);
                    }
                    del(newsId);
                } else {
                    layer.msg("请选择需要删除的权限");
                }
            })

            //列表操作
            table.on('tool(list)', function (obj) {
                var layEvent = obj.event,
                    data = obj.data;

                if (layEvent === 'edit') { //编辑
                    addData('{{url('admin/auth-rule/edit')}}/' + data.id);
                } else if (layEvent === 'del') { //删除
                    del(data.id);
                }
            });

            //执行删除操作
            function del(data_id) {
                layer.confirm('确定删除选中的权限？', {icon: 3, title: '提示信息'}, function (index) {
                    layer.close(index);
                    var index1 = layer.msg('删除中，请稍候', {icon: 16, time: false, shade: 0.8});
                    $.post('{{url('admin/auth-rule/destroy')}}', {
                        id: data_id  //将需要删除的newsId作为参数传入
                    }, function (res) {
                        layer.close(index1);
                        if (res.status === 0) {
                            layer.msg(res.msg, {icon: 2});
                            return false;
                        }
                        layer.msg(res.msg, {icon: 1});
                        tableIns.reload();
                    })
                })
            }

        })

    </script>
@endsection