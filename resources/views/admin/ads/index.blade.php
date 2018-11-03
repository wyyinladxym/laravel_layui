@extends('admin.layouts.master')

@section('title', '轮播图列表')

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
                    <a class="layui-btn layui-btn-normal addNews_btn">添加轮播图</a>
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
                url: '{{url('admin/ads/lists')}}',
                cellMinWidth: 95,
                page: true,
                height: "full-125",
                limits: [10, 20, 30, 40],
                limit: 15,
                id: "listTable",
                cols: [[
                    {type: "checkbox", fixed: "left", width: 50},
                    {field: 'ad_name', title: '广告标题', minWidth: 100, align: "left"},
                    {
                        field: 'ad_pic', title: '轮播图', minWidth: 200, align: 'center', templet: function (d) {
                            return '<image class="layui-blue" src="' + d.ad_pic + '">';
                        }
                    },
                    {
                        field: 'ad_link', title: '跳转链接', minWidth: 200, align: 'center', templet: function (d) {
                            return '<a class="layui-blue" href="' + d.ad_link + '">' + d.ad_link + '</a>';
                        }
                    },
                    {
                        field: 'is_show', title: '状态', align: 'center', templet: function (d) {
                            return '<input type="checkbox" name="newStatus" lay-filter="newStatus" lay-skin="switch" data-id="' + d.id + '" lay-text="显示|隐藏"  ' + (d.is_show ? 'checked' : '') + '>';
                        }
                    },
                    {field: 'sort_order', title: '排序', align: 'center'},
                    {field: 'updated_at', title: '修改时间', align: 'center', minWidth: 150},
                    {field: 'created_at', title: '创建时间', align: 'center', minWidth: 150},
                    {title: '操作', minWidth: 175, templet: '#listBar', fixed: "right", align: "center"}
                ]]
            });

            //更新状态
            form.on('switch(newStatus)', function (data) {
                var index = layer.msg('修改中，请稍候', {icon: 16, time: false, shade: 0.8});
                var id = $(data.elem).attr('data-id');
                var is_show = data.elem.checked ? 1 : 0;
                $.post("{{url('admin/ads/edit-status')}}/" + id + "", {'is_show': is_show}, function (res) {
                    layer.close(index);
                    if (res.status === 0) {
                        layer.msg(res.msg, {icon: 2});
                        return false;
                    }
                    top.layer.msg(res.msg, {icon: 1});
                })
            })

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
                var index = layui.layer.open({
                    title: "编辑",
                    type: 2,
                    content: url,
                    success: function (layero, index) {
                        setTimeout(function () {
                            layui.layer.tips('点击此处返回列表', '.layui-layer-setwin .layui-layer-close', {
                                tips: 3
                            });
                        }, 500)
                    }
                })
                layui.layer.full(index);
                window.sessionStorage.setItem("index", index);
                //改变窗口大小时，重置弹窗的宽高，防止超出可视区域（如F12调出debug的操作）
                $(window).on("resize", function () {
                    layui.layer.full(window.sessionStorage.getItem("index"));
                })
            }

            $(".addNews_btn").click(function () {
                addData('{{url('admin/ads/create')}}');
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
                    layer.msg("请选择需要删除的轮播图");
                }
            })

            //列表操作
            table.on('tool(list)', function (obj) {
                var layEvent = obj.event,
                    data = obj.data;

                if (layEvent === 'edit') { //编辑
                    addData('{{url('admin/ads/edit')}}/' + data.id);
                } else if (layEvent === 'del') { //删除
                    del(data.id);
                }
            });

            //执行删除操作
            function del(data_id) {
                layer.confirm('确定删除选中的轮播图？', {icon: 3, title: '提示信息'}, function (index) {
                    layer.close(index);
                    var index1 = layer.msg('删除中，请稍候', {icon: 16, time: false, shade: 0.8});
                    $.post('{{url('admin/ads/destroy')}}', {
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