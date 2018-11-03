@extends('admin.layouts.master')

@section('title','首页')

@section('content')
	<blockquote class="layui-elem-quote layui-bg-green">
		<div id="nowTime"></div>
	</blockquote>
	<div class="layui-row layui-col-space10 panel_box">
		<div class="panel layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
			<a href="javascript:;" data-url="http://fly.layui.com/case/u/3198216" target="_blank">
				<div class="panel_icon layui-bg-green">
					<i class="layui-anim seraph icon-good"></i>
				</div>
				<div class="panel_word">
					<span>为我点赞</span>
					<cite>点赞地址链接</cite>
				</div>
			</a>
		</div>
		<div class="panel layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
			<a href="javascript:;" data-url="https://github.com/BrotherMa/layuicms2.0" target="_blank">
				<div class="panel_icon layui-bg-black">
					<i class="layui-anim seraph icon-github"></i>
				</div>
				<div class="panel_word">
					<span>Github</span>
					<cite>模版下载链接</cite>
				</div>
			</a>
		</div>
		<div class="panel layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
			<a href="javascript:;" data-url="https://gitee.com/layuicms/layuicms2.0" target="_blank">
				<div class="panel_icon layui-bg-red">
					<i class="layui-anim seraph icon-oschina"></i>
				</div>
				<div class="panel_word">
					<span>码云</span>
					<cite>模版下载链接</cite>
				</div>
			</a>
		</div>
		<div class="panel layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
			<a href="javascript:;" data-url="page/user/userList.html">
				<div class="panel_icon layui-bg-orange">
					<i class="layui-anim seraph icon-icon10" data-icon="icon-icon10"></i>
				</div>
				<div class="panel_word userAll">
					<span></span>
					<em>用户总数</em>
					<cite class="layui-hide">用户中心</cite>
				</div>
			</a>
		</div>
		<div class="panel layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
			<a href="javascript:;" data-url="page/systemSetting/icons.html">
				<div class="panel_icon layui-bg-cyan">
					<i class="layui-anim layui-icon" data-icon="&#xe857;">&#xe857;</i>
				</div>
				<div class="panel_word outIcons">
					<span></span>
					<em>外部图标</em>
					<cite class="layui-hide">图标管理</cite>
				</div>
			</a>
		</div>
		<div class="panel layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
			<a href="javascript:;">
				<div class="panel_icon layui-bg-blue">
					<i class="layui-anim seraph icon-clock"></i>
				</div>
				<div class="panel_word">
					<span class="loginTime"></span>
					<cite>上次登录时间</cite>
				</div>
			</a>
		</div>
	</div>
	<div class="layui-row layui-col-space10">
		<div class="layui-col-lg6 layui-col-md12">
			<blockquote class="layui-elem-quote title">系统基本参数</blockquote>
			<table class="layui-table magt0">
				<colgroup>
					<col width="150">
					<col>
				</colgroup>
				<tbody>
				@foreach ($info as $key=>$val)
					<tr>
						<td>{{$key}}</td>
						<td>{{$val}}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			<blockquote class="layui-elem-quote title">最新文章 <i class="layui-icon layui-red">&#xe756;</i></blockquote>
			<table class="layui-table mag0" lay-skin="line">
				<colgroup>
					<col>
					<col width="110">
				</colgroup>
				<tbody class="hot_news"></tbody>
			</table>
		</div>
		<div class="layui-col-lg6 layui-col-md12">
			<blockquote class="layui-elem-quote title">更新日志</blockquote>
			<div class="layui-elem-quote layui-quote-nm history_box magb0">
				<ul class="layui-timeline">
					<li class="layui-timeline-item">
						<i class="layui-icon layui-timeline-axis">&#xe63f;</i>
						<div class="layui-timeline-content layui-text">
							<div class="layui-timeline-title">
								<h3 class="layui-inline">结合大家需求并修改部分bug后形成的layuiCMS V1.0.1发布　</h3>
								<span class="layui-badge-rim">2017-07-05</span>
							</div>
							<ul>
								<li># v1.0.1（优化） - 2017-06-25</li>
								<li>修改刚进入页面无任何操作时按回车键提示“请输入解锁密码！”</li>
								<li>优化关闭弹窗按钮的提示信息位置问题【可能是因为加载速度的原因，造成这个问题，所以将提示信息做了一个延时】</li>
								<li>“个人资料”提供修改功能</li>
								<li>顶部天气信息自动判断位置【忘记之前是怎么想的做成北京的了，可能是我在大首都吧，哈哈。。。】</li>
								<li>优化“用户列表”无法查询到新添加的用户【竟然是因为我把key值写错了，该死。。。】</li>
								<li>将左侧菜单做成json方式调用，而不是js调用，方便开发使用。同时添加了参数配置和非窗口模式打开的判断，【如登录页面】</li>
								<li>优化部分页面样式问题</li>
								<li>优化添加窗时如果导航不存在图标无法添加成功</li>
								<br>
								<li># v1.0.1（新增） - 2017-07-05</li>
								<li>增加“用户列表”批量删除功能【可能当时忘记添加了吧。。。】</li>
								<li>顶部窗口导航添加“关闭其他”、“关闭全部”功能，同时修改菜单窗口过多的展示效果【在此感谢larryCMS给予的启发】</li>
								<li>添加可隐藏左侧菜单功能【之前考虑没必要添加，但是很多朋友要求加上，那就加上吧，嘿嘿。。。】</li>
								<li>增加换肤功能【之前就想添加的，但是一直没有找到好的方式（好吧，其实是我忘记了），此方法相对简单，不是普遍适用，只简单的做个功能，如果实际用到建议单独写一套样式，将边框颜色、按钮颜色等统一调整，此处为保证代码的简洁性，只做简单的功能，不做赘述，另外“自定义”颜色中未做校验，所以要写入正确的色值。如“#f00”】</>
								<li>增加登录页面【背景视频仅作样式参考，实际使用中请自行更换为其他视频或图片，否则造成的任何问题使用者本人承担。】</li>
								<li>新增打开窗口的动画效果</li>
							</ul>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
@endsection
@section('script')
	<script type="text/javascript" src="{{asset('/js/admin/main.js')}}"></script>
@endsection
