@extends('admin.layouts.master')

@section('title', '文章列表')

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
                    <a class="layui-btn layui-btn-normal addNews_btn">添加文章</a>
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

            //列表
            var tableIns = table.render({
                elem: '#list',
                url: '{{url('admin/articles/lists')}}',
                cellMinWidth: 95,
                page: true,
                height: "full-125",
                limits: [10, 20, 30, 40],
                limit: 15,
                id: "listTable",
                cols: [[
                    {type: "checkbox", fixed: "left", width: 50},
                    {field: 'title', title: '文章标题', width: 200, align: "left"},
                    {
                        field: 'master_pic', title: '文章图片', width: 200, align: 'center', templet: function (d) {
                            return '<image class="layui-blue master_pic"   src="' + d.master_pic + '">';
                        }
                    },
                    {
                        field: 'video', title: '文章视频', width: 120, align: "center", templet: function (d) {
                            return '<span class="layui-btn layui-btn-xs articles_video" data-src="' + d.video + '" data-title="' + d.title + '"><i class="layui-icon">&#xe6ed;</i>查看</span>';
                        }
                    },
                    {
                        field: 'abstract', title: '发布状态', width: 100, align: "left", templet: function (d) {
                            if (d.is_show == "0") {
                                return '<span class="layui-red">未发布</span>';
                            } else if (d.is_show == "1") {
                                return '<span class="layui-blue">已发布</span>';
                            }
                            return '<span style="color: #FFB800;">定时发布 ' + formatData(d.show_time) + '</span>';
                        }
                    },
                    {
                        field: 'is_top', title: '置顶', align: 'center', width: 100, templet: function (d) {
                            return '<input type="checkbox" name="is_top" lay-filter="newStatus" lay-skin="switch" data-id="' + d.id + '" lay-text="置顶|默认"  ' + (d.is_top ? 'checked' : '') + '>';
                        }
                    },
                    {field: 'browse_num', title: '浏览量', width: 100, align: "left"},
                    {field: 'collect_num', title: '收藏量', width: 100, align: "left"},
                    {field: 'sort_order', title: '排序', align: 'center', edit: 'text', width: 100},
                    {field: 'updated_at', title: '修改时间', align: 'center', width: 120},
                    {field: 'created_at', title: '创建时间', align: 'center', width: 120},
                    {title: '操作', minWidth: 175, templet: '#listBar', fixed: "right", align: "center"}
                ]],
                done: function (res, curr, count) {
                    hoverOpenImg();
                   $('.articles_video').click(function(){
                       showVideo($(this).attr('data-src'), $(this).attr('data-title'));
                   })
                }
            });

            //显示图片
            function hoverOpenImg() {
                var img_show = null; // tips提示
                $('.master_pic').hover(function () {
                    var img = "<img class='img_msg' src='" + $(this).attr('src') + "' style='width:200px;' />";
                    img_show = layer.tips(img, this, {
                        tips: [3, 'rgba(41,41,41,.0)'],
                        area: ['auto', 'auto']
                    });
                }, function () {
                    layer.close(img_show);
                });
            }

            //显示视频
            function showVideo(src = '', title = '视频') {
                if (!src) {
                    layer.msg('暂无上传视频');
                    return false;
                }
                var video_html = '<video src="' + src + '" controls="controls" class="magt10"style="width:100%">您的浏览器不支持 video 标签。</video>'
                var index = layer.open({
                    type: 1,
                    title: title,
                    content: video_html,
                    shift:1,
                });
            }

            //更新状态
            form.on('switch(newStatus)', function (data) {
                var index = layer.msg('修改中，请稍候', {icon: 16, time: false, shade: 0.8});
                var id = $(data.elem).attr('data-id');
                var is_top= data.elem.checked ? 1 : 0;
                $.post("{{url('admin/articles/edit-row')}}/" + id + "", {'is_top': is_top}, function (res) {
                    layer.close(index);
                    if (res.status != 1) {
                        layer.msg(res.msg, {icon: 2});
                        return false;
                    }
                    tableIns.reload();
                    layer.msg(res.msg, {icon: 1});
                }).error(function(){
                    layer.msg('操作失败', {icon: 2});
                    return false;
                })
            })

            //监听单元格编辑
            table.on('edit(list)', function (obj) {
                var value = obj.value //得到修改后的值
                    , data = obj.data //得到所在行所有键值
                    , field = obj.field; //得到字段
                var index = layer.msg('修改中，请稍候', {icon: 16, time: false, shade: 0.8});
                $.post("{{url('admin/articles/edit-row')}}/" + data.id + "", {[field]: value}, function (res) {
                    layer.close(index);
                    if (res.status != 1) {
                        layer.msg(res.msg, {icon: 2});
                        return false;
                    }
                    tableIns.reload();
                    layer.msg(res.msg, {icon: 1});
                }).error(function () {
                    layer.msg('编辑失败', {icon: 2});
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
                addData('{{url('admin/articles/create')}}');
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
                    layer.msg("请选择需要删除的文章");
                }
            })

            //列表操作
            table.on('tool(list)', function (obj) {
                var layEvent = obj.event,
                    data = obj.data;

                if (layEvent === 'edit') { //编辑
                    addData('{{url('admin/articles/edit')}}/' + data.id);
                } else if (layEvent === 'del') { //删除
                    del(data.id);
                }
            });

            //执行删除操作
            function del(data_id) {
                layer.confirm('确定删除选中的文章？', {icon: 3, title: '提示信息'}, function (index) {
                    layer.close(index);
                    var index1 = layer.msg('删除中，请稍候', {icon: 16, time: false, shade: 0.8});
                    $.post('{{url('admin/articles/destroy')}}', {
                        id: data_id  //将需要删除的newsId作为参数传入
                    }, function (res) {
                        layer.close(index1);
                        if (res.status != 1) {
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