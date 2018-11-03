@extends('admin.layouts.master')

@section('title', '新增管理员')

@section('content')
	<form class="layui-form" style="width:80%;">
		<div class="layui-form-item layui-row layui-col-xs12">
			<label class="layui-form-label">昵称</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input userNick" lay-verify="required" placeholder="请输入登录名">
			</div>
		</div>
		<div class="layui-form-item layui-row layui-col-xs12">
			<label class="layui-form-label">登录名</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input userName" lay-verify="required" placeholder="请输入登录名">
			</div>
		</div>
		<div class="layui-form-item layui-row layui-col-xs12">
			<label class="layui-form-label">密码</label>
			<div class="layui-input-block">
				<input type="password" class="layui-input userPwd" lay-verify="required" placeholder="请输入密码" >
			</div>
		</div>
		<div class="layui-form-item layui-row layui-col-xs12">
			<label class="layui-form-label">邮箱</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input userEmail" lay-verify="email" placeholder="请输入邮箱">
			</div>
		</div>
		<div class="layui-row">
			<div class="magb15 layui-col-md4 layui-col-xs12">
				<label class="layui-form-label">角色</label>
				<div class="layui-input-block">
					<select name="userRole" class="userRole" lay-filter="userRole">
						<option value="0">超级管理员</option>
					</select>
				</div>
			</div>
			<div class="magb15 layui-col-md4 layui-col-xs12">
				<label class="layui-form-label">状态</label>
				<div class="layui-input-block">
					<select name="userStatus" class="userStatus" lay-filter="userStatus">
						<option value="1">正常使用</option>
						<option value="0">限制用户</option>
					</select>
				</div>
			</div>
		</div>
		<div class="layui-form-item layui-row layui-col-xs12">
			<div class="layui-input-block">
				<button class="layui-btn layui-btn-sm" lay-submit="" lay-filter="addUser">立即添加</button>
				<button type="reset" class="layui-btn layui-btn-sm layui-btn-primary">取消</button>
			</div>
		</div>
	</form>
@endsection

@section('script')
	<script type="text/javascript">
        layui.use(['form','layer'],function(){
            var form = layui.form
            layer = parent.layer === undefined ? layui.layer : top.layer,
                $ = layui.jquery;

			//设置ajax请求表头添加X-CSRF-TOKEN
            start_token();

            form.on("submit(addUser)",function(data){
                //弹出loading
                //var index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.8});
                // 实际使用时的提交信息
                $.post("{{url('admin/admins/create')}}",{
                    nickname : $(".userNick").val(),  //昵称
                    username: $(".userName").val(),  //登录名
                    password : $(".userPwd").val(),  //登录名
                    email : $(".userEmail").val(),  //邮箱
                    rold_id : data.field.userRole,  //角色
                    status : data.field.userStatus, //用户状态
                },function(res){
					console.log(res);
                })


                // setTimeout(function(){
                //     top.layer.close(index);
                //     top.layer.msg("用户添加成功！");
                //     layer.closeAll("iframe");
                //     //刷新父页面
                //     parent.location.reload();
                // },2000);
                return false;
            })

        })
	</script>
@endsection
