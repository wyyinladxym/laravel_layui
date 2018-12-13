@extends('admin.layouts.master')

@section('title', '编辑文章')

@section('content')
    <form class="layui-form layui-row layui-col-space10">
        <div class="layui-col-md9 layui-col-xs12">
            <div class="layui-row layui-col-space10">
                <div class="layui-col-md9 layui-col-xs7">
                    <div class="layui-form-item magt3">
                        <label class="layui-form-label">文章标题</label>
                        <div class="layui-input-block">
                            <input type="text" name="title" value="{{$data['title'] or ''}}"
                                   class="layui-input newsName" lay-verify="newsName" placeholder="请输入文章标题">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">内容摘要</label>
                        <div class="layui-input-block">
                            <textarea name="abstract" placeholder="请输入内容摘要"
                                      class="layui-textarea abstract">{{$data['abstract'] or ''}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md3 layui-col-xs5">
                    <div class="layui-upload-list thumbBox mag0 magt3">
                        <img class="layui-upload-img thumbImg" src="{{$data['master_pic'] or ''}}">
                        <input type="hidden" name="master_pic" value="{{$data['master_pic'] or ''}}">
                    </div>
                </div>
            </div>
            <div class="layui-form-item magb0">
                <label class="layui-form-label">文章内容</label>
                <div class="layui-input-block">
                    <textarea name="content" class="layui-textarea layui-hide"
                              id="news_content" lay-verify="content">{{$data['content'] or ''}}</textarea>
                </div>
            </div>
        </div>
        <div class="layui-col-md3 layui-col-xs12">
            <blockquote class="layui-elem-quote title"><i class="seraph icon-caidan"></i> 分类目录</blockquote>
            <div class="border">
                <select name="cat_id" lay-search>
                    <option value="0">顶级分类</option>
                    @foreach ($cat_tree as $val)
                        <option value="{{$val['id']}}" {{isset($data['cat_id']) && $data['cat_id'] == $val['id'] ? 'selected' : ''}} >{{$val['html']}}</option>
                    @endforeach
                </select>
            </div>

            <blockquote class="layui-elem-quote title magt10"><i class="layui-icon">&#xe6ed;</i> 上传视频</blockquote>
            <div class="border">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-normal" id="option_video">选择文件</button>
                    <button type="button" class="layui-btn" id="upload_video">开始上传</button>
                    <div class="layui-progress layui-progress-big layui-hide magt10 video_progress"
                         lay-showPercent="yes" lay-filter="progressBar">
                        <div class="layui-progress-bar layui-bg-red" lay-percent="0%"></div>
                    </div>
                    <video src="{{$data['video'] or '#'}}" controls="controls"
                           class="magt10 video {{isset($data['video']) && $data['video'] ? '' : 'layui-hide'}}"
                           style="width:100%">
                        您的浏览器不支持 video 标签。
                    </video>
                    <input type="hidden" name="video" value="{{$data['video'] or ''}}">
                </div>
            </div>

            <blockquote class="layui-elem-quote title magt10"><i class="layui-icon">&#xe609;</i> 发布</blockquote>
            <div class="border">
                <div class="layui-form-item">
                    <label class="layui-form-label"><i class="layui-icon">&#xe609;</i> 发　布</label>
                    <div class="layui-input-block">
                        <input type="radio" name="is_show" value="0"
                               {{isset($data['is_show']) && $data['is_show'] == 0 ? 'checked' : ''}} title="隐藏"
                               lay-skin="primary" lay-filter="release"/>
                        <input type="radio" name="is_show" value="1"
                               {{isset($data['is_show']) && $data['is_show'] == 1 ? 'checked' : ''}} title="立即发布"
                               lay-skin="primary" lay-filter="release"/>
                        <input type="radio" name="is_show" value="2"
                               {{isset($data['is_show']) && $data['is_show'] == 2 ? 'checked' : ''}} title="定时发布"
                               lay-skin="primary" lay-filter="release"/>
                    </div>
                </div>
                <div class="layui-form-item {{isset($data['is_show']) && $data['is_show'] == 2 ? '' : 'layui-hide'}} releaseDate">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <input type="text" name="show_time"
                               value="{{isset($data['show_time']) && $data['show_time'] ? date('Y-m-d H:i:s',$data['show_time']) : ''}}"
                               class="layui-input" id="release" placeholder="请选择日期和时间" readonly/>
                    </div>
                </div>
                <div class="layui-form-item newsTop">
                    <label class="layui-form-label"><i class="seraph icon-zhiding"></i> 置　顶</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="is_top" value="1" lay-skin="switch"
                               lay-text="是|否" {{isset($data['is_top']) && $data['is_top'] == 1 ? 'checked' : ''}}>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><i class="seraph icon-chakan"></i> 排　序</label>
                    <div class="layui-input-block">
                        <input type="text" name="sort_order" value="{{$data['sort_order'] or 0}}" class="layui-input" >
                    </div>
                </div>
                <hr class="layui-bg-gray"/>
                <div class="layui-right">
                    <a class="layui-btn layui-btn-sm" lay-filter="addNews" lay-submit><i class="layui-icon">&#xe609;</i>发布</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script type="text/javascript">
        layui.use(['form', 'layer', 'layedit', 'laydate', 'upload', 'element'], function () {
            var form = layui.form
            layer = parent.layer === undefined ? layui.layer : top.layer,
                upload = layui.upload,
                layedit = layui.layedit,
                laydate = layui.laydate,
                element = layui.element,
                $ = layui.jquery;

            //上传缩略图
            upload.render({
                elem: '.thumbBox',
                url: '{{url("admin/articles/upload-pic")}}',
                method: "post",
                done: function (res, index, upload) {
                    if (res.status != 1) {
                        layer.msg(res.msg, {icon: 2});
                        return false;
                    }
                    layer.msg(res.msg, {icon: 1});
                    $('.thumbImg').attr('src', res.data.src);
                    $('input[name="master_pic"]').val(res.data.src);
                    $('.thumbBox').css("background", "#fff");
                }
            });

            //视频上传
            upload.render({
                elem: '#option_video',
                url: '{{url("admin/articles/upload-video")}}',
                auto: false,
                accept: 'video',
                bindAction: '#upload_video',
                progress: function (e, percent) {
                    $(".video_progress").removeClass("layui-hide");
                    element.progress('progressBar', percent + '%');
                },
                done: function (res) {
                    if (res.status != 1) {
                        layer.msg(res.msg, {icon: 2});
                        return false;
                    }
                    layer.msg(res.msg, {icon: 1});
                    $(".video_progress").addClass("layui-hide");
                    $('.video').removeClass("layui-hide").attr('src', res.data.src);
                    $("input[name='video']").val(res.data.src);
                },
                error: function (index, upload) {
                    $(".video_progress").addClass("layui-hide"); //隐藏进度条
                    $(".video").addClass("layui-hide").attr('src', ''); //隐藏视频播放器
                    $("input[name='video']").val('');
                }
            });

            //定时发布
            var submitTime = formatData();
            laydate.render({
                elem: '#release',
                type: 'datetime',
                trigger: "click",
                done: function (value, date, endDate) {
                    submitTime = value;
                }
            });
            form.on("radio(release)", function (data) {
                if (data.elem.title == "定时发布") {
                    $(".releaseDate").removeClass("layui-hide");
                    $(".releaseDate #release").attr("lay-verify", "required");
                } else {
                    $(".releaseDate").addClass("layui-hide");
                    $(".releaseDate #release").removeAttr("lay-verify");
                    submitTime = formatData();
                }
            });

            form.verify({
                newsName: function (val) {
                    if (val == '') {
                        return "文章标题不能为空";
                    }
                },
                content: function (val) {
                    return layedit.sync(editIndex);
                }
            })

            //创建一个编辑器
            var editIndex = layedit.build('news_content', {
                height: 535,
                uploadImage: {
                    url: '{{url("admin/articles/upload-pic")}}',
                    type: 'post'
                }
            });
            //layedit.sync(editIndex);
            form.on("submit(addNews)", function (data) {
                if (data.field.is_top == undefined) {
                    data.field.is_top = 0;
                }
                delete data.field.file;
                //弹出loading
                var index = top.layer.msg('数据提交中，请稍候', {icon: 16, time: false, shade: 0.8});
                // 实际使用时的提交信息
                $.post("{{$sub_url}}", data.field, function (res) {
                    if (res.status != 1) {
                        layer.msg(res.msg, {icon: 2});
                        return false;
                    }
                    top.layer.close(index);
                    top.layer.msg(res.msg, {icon: 1});
                    layer.closeAll("iframe");
                    //刷新父页面
                    parent.location.reload();
                }).error(function () {
                    layer.msg('操作失败', {icon: 2});
                    top.layer.close(index);
                })
                return false;
            })

        })
    </script>
@endsection
