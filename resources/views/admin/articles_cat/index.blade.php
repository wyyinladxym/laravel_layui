@extends('admin.layouts.master')

@section('title', '文章分类')

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
                    <a class="layui-btn layui-btn-normal addNews_btn">添加分类</a>
                </div>
                <div class="layui-btn-group">
                    <a class="layui-btn layui-btn-warm btn-expand">全部展开</a>
                    <a class="layui-btn layui-btn-warm btn-fold">全部折叠</a>
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
        layui.config({
            base: "/module/"
        }).extend({
            "treetable": "treetable-lay/treetable"
        })
        layui.use(['form', 'layer', 'table', 'laytpl', 'treetable'], function () {
            var form = layui.form
            layer = parent.layer === undefined ? layui.layer : top.layer,
                $ = layui.jquery,
                laytpl = layui.laytpl,
                table = layui.table;
            var treetable = layui.treetable;

            //列表
            var tableIns = function () {
                layer.load(2);
                treetable.render({
                    treeColIndex: 1, //树形图标显示在第几列
                    treeSpid: 0, //最上级的父级id
                    treeIdName: 'id', //id字段的名称
                    treePidName: 'parent_id', //pid字段的名称
                    treeDefaultClose: false, //是否默认折叠
                    elem: '#list',
                    url: '{{url('admin/articles-cat/lists')}}',
                    page: false,
                    id: "listTable",
                    cols: [[
                        {type: 'numbers'},
                        {field: 'cat_name', title: '分类名称', minWidth: 200, align: 'left'},
                        {
                            field: 'is_show', title: '是否显示', align: 'center', templet: function (d) {
                                return '<input type="checkbox" name="is_show" lay-filter="newStatus" lay-skin="switch" data-id="' + d.id + '" lay-text="显示|隐藏"  ' + (d.is_show ? 'checked' : '') + '>';
                            }
                        },
                        {
                            field: 'show_in_nav', title: '导航显示', align: 'center', templet: function (d) {
                                return '<input type="checkbox" name="show_in_nav" lay-filter="newStatus" lay-skin="switch" data-id="' + d.id + '" lay-text="显示|隐藏"  ' + (d.show_in_nav ? 'checked' : '') + '>';
                            }
                        },
                        {field: 'sort_order', title: '排序', align: 'center', edit: 'text'},
                        {title: '操作', minWidth: 150, templet: '#listBar', align: "center"}
                    ]],
                    done: function () {
                        layer.closeAll('loading');
                    }
                })
            }
            tableIns();

            //监听单元格编辑
            table.on('edit(list)', function (obj) {
                var value = obj.value //得到修改后的值
                    , data = obj.data //得到所在行所有键值
                    , field = obj.field; //得到字段
                var index = layer.msg('修改中，请稍候', {icon: 16, time: false, shade: 0.8});
                $.post("{{url('admin/articles-cat/edit-row')}}/" + data.id + "", {[field]: value}, function (res) {
                    layer.close(index);
                    if (res.status === 0) {
                        layer.msg(res.msg, {icon: 2});
                        return false;
                    }
                    tableIns();
                    layer.msg(res.msg, {icon: 1});
                }).error(function () {
                    layer.msg('修改失败', {icon: 2});
                    layer.close(index);
                    return false;
                })
            });

            //更新状态
            form.on('switch(newStatus)', function (data) {
                var index = layer.msg('修改中，请稍候', {icon: 16, time: false, shade: 0.8});
                var id = $(data.elem).attr('data-id');
                var name = $(data.elem).attr('name');
                var status = data.elem.checked ? 1 : 0;
                $.post("{{url('admin/articles-cat/edit-row')}}/" + id + "", {[name]: status}, function (res) {
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
                var keyword = $('.searchVal').val();
                var searchCount = 0;
                $('#list').next('.treeTable').find('.layui-table-body tbody tr td').each(function () {
                    $(this).css('background-color', 'transparent');
                    var text = $(this).text();
                    if (keyword != '' && text.indexOf(keyword) >= 0) {
                        $(this).css('background-color', 'rgba(250,230,160,0.5)');
                        if (searchCount == 0) {
                            treetable.expandAll('#list');
                            $('html,body').stop(true);
                            $('html,body').animate({scrollTop: $(this).offset().top - 150}, 500);
                        }
                        searchCount++;
                    }
                });
                if (keyword == '') {
                    layer.msg("请输入搜索内容", {icon: 5});
                } else if (searchCount == 0) {
                    layer.msg("没有匹配结果", {icon: 5});
                }
            });

            $('.btn-expand').click(function () {
                treetable.expandAll('#list');
            });

            $('.btn-fold').click(function () {
                treetable.foldAll('#list');
            });

            function addData(url) {
                var index = layer.open({
                    title: "编辑",
                    type: 2,
                    area: ["360px", "500px"],
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
                addData('{{url('admin/articles-cat/create')}}');
            })

            //列表操作
            table.on('tool(list)', function (obj) {
                var layEvent = obj.event,
                    data = obj.data;

                if (layEvent === 'edit') { //编辑
                    addData('{{url('admin/articles-cat/edit')}}/' + data.id);
                } else if (layEvent === 'del') { //删除
                    del(data.id);
                }
            });

            //执行删除操作
            function del(data_id) {
                layer.confirm('确定删除选中的分类？', {icon: 3, title: '提示信息'}, function (index) {
                    layer.close(index);
                    var index1 = layer.msg('删除中，请稍候', {icon: 16, time: false, shade: 0.8});
                    $.post('{{url('admin/articles-cat/destroy')}}', {
                        id: data_id  //将需要删除的newsId作为参数传入
                    }, function (res) {
                        layer.close(index1);
                        if (res.status === 0) {
                            layer.msg(res.msg, {icon: 2});
                            return false;
                        }
                        tableIns();
                        layer.msg(res.msg, {icon: 1});
                    }).error(function () {
                        layer.close(index1);
                        layer.msg('操作失败', {icon: 2});
                    })
                })
            }
        })

    </script>
@endsection