<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>修改密码--layui后台管理模板 2.0</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" href="{{asset('/frame/layui/css/layui.css')}}" media="all" />
	<link rel="stylesheet" href="{{asset('/css/admin/public.css')}}" media="all" />
</head>
<body class="childrenBody">
<form class="layui-form layui-row changePwd">
	<div class="layui-col-xs12 layui-col-sm6 layui-col-md6">
		<div class="layui-input-block layui-red pwdTips">旧密码请输入“123456”，新密码必须两次输入一致才能提交</div>
		<div class="layui-form-item">
			<label class="layui-form-label">用户名</label>
			<div class="layui-input-block">
				<input type="text" value="驊驊龔頾" disabled class="layui-input layui-disabled">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">旧密码</label>
			<div class="layui-input-block">
				<input type="password" value="" placeholder="请输入旧密码" lay-verify="required|oldPwd" class="layui-input pwd">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">新密码</label>
			<div class="layui-input-block">
				<input type="password" value="" placeholder="请输入新密码" lay-verify="required|newPwd" id="oldPwd" class="layui-input pwd">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">确认密码</label>
			<div class="layui-input-block">
				<input type="password" value="" placeholder="请确认密码" lay-verify="required|confirmPwd" class="layui-input pwd">
			</div>
		</div>
		<div class="layui-form-item">
			<div class="layui-input-block">
				<button class="layui-btn" lay-submit="" lay-filter="changePwd">立即修改</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript" src="{{asset('/frame/layui/layui.js')}}"></script>
<script type="text/javascript">
    layui.use(['form','layer','laydate','table','laytpl'],function(){
        var form = layui.form,
            layer = parent.layer === undefined ? layui.layer : top.layer,
            $ = layui.jquery,
            laydate = layui.laydate,
            laytpl = layui.laytpl,
            table = layui.table;

        //添加验证规则
        form.verify({
            oldPwd : function(value, item){
                if(value != "123456"){
                    return "密码错误，请重新输入！";
                }
            },
            newPwd : function(value, item){
                if(value.length < 6){
                    return "密码长度不能小于6位";
                }
            },
            confirmPwd : function(value, item){
                if(!new RegExp($("#oldPwd").val()).test(value)){
                    return "两次输入密码不一致，请重新输入！";
                }
            }
        })

        //用户等级
        table.render({
            elem: '#userGrade',
            url : '../../json/userGrade.json',
            cellMinWidth : 95,
            cols : [[
                {field:"id", title: 'ID', width: 60, fixed:"left",sort:"true", align:'center', edit: 'text'},
                {field: 'gradeIcon', title: '图标展示', templet:'#gradeIcon', align:'center'},
                {field: 'gradeName', title: '等级名称', edit: 'text', align:'center'},
                {field: 'gradeValue', title: '等级值', edit: 'text',sort:"true", align:'center'},
                {field: 'gradeGold', title: '默认金币', edit: 'text',sort:"true", align:'center'},
                {field: 'gradePoint', title: '默认积分', edit: 'text',sort:"true", align:'center'},
                {title: '当前状态',minWidth:100, templet:'#gradeBar',fixed:"right",align:"center"}
            ]]
        });

        form.on('switch(gradeStatus)', function(data){
            var tipText = '确定禁用当前会员等级？';
            if(data.elem.checked){
                tipText = '确定启用当前会员等级？'
            }
            layer.confirm(tipText,{
                icon: 3,
                title:'系统提示',
                cancel : function(index){
                    data.elem.checked = !data.elem.checked;
                    form.render();
                    layer.close(index);
                }
            },function(index){
                layer.close(index);
            },function(index){
                data.elem.checked = !data.elem.checked;
                form.render();
                layer.close(index);
            });
        });
        //新增等级
        $(".addGrade").click(function(){
            var $tr = $(".layui-table-body.layui-table-main tbody tr:last");
            if($tr.data("index") < 9) {
                var newHtml = '<tr data-index="' + ($tr.data("index") + 1) + '">' +
                    '<td data-field="id" data-edit="text" align="center"><div class="layui-table-cell laytable-cell-1-id">' + ($tr.data("index") + 2) + '</div></td>' +
                    '<td data-field="gradeIcon" align="center" data-content="icon-vip' + ($tr.data("index") + 2) + '"><div class="layui-table-cell laytable-cell-1-gradeIcon"><span class="seraph vip' + ($tr.data("index") + 2) + ' icon-vip' + ($tr.data("index") + 2) + '"></span></div></td>' +
                    '<td data-field="gradeName" data-edit="text" align="center"><div class="layui-table-cell laytable-cell-1-gradeName">请输入等级名称</div></td>' +
                    '<td data-field="gradeValue" data-edit="text" align="center"><div class="layui-table-cell laytable-cell-1-gradeValue">0</div></td>' +
                    '<td data-field="gradeGold" data-edit="text" align="center"><div class="layui-table-cell laytable-cell-1-gradeGold">0</div></td>' +
                    '<td data-field="gradePoint" data-edit="text" align="center"><div class="layui-table-cell laytable-cell-1-gradePoint">0</div></td>' +
                    '<td data-field="' + ($tr.data("index") + 1) + '" align="center" data-content="" data-minwidth="100"><div class="layui-table-cell laytable-cell-1-' + ($tr.data("index") + 1) + '"> <input type="checkbox" name="gradeStatus" lay-filter="gradeStatus" lay-skin="switch" lay-text="启用|禁用" checked=""><div class="layui-unselect layui-form-switch layui-form-onswitch" lay-skin="_switch"><em>启用</em><i></i></div></div></td>' +
                    '</tr>';
                $(".layui-table-body.layui-table-main tbody").append(newHtml);
                $(".layui-table-fixed.layui-table-fixed-l tbody").append('<tr data-index="' + ($tr.data("index") + 1) + '"><td data-field="id" data-edit="text" align="center"><div class="layui-table-cell laytable-cell-1-id">' + ($tr.data("index") + 2) +'</div></td></tr>');
                $(".layui-table-fixed.layui-table-fixed-r tbody").append('<tr data-index="' + ($tr.data("index") + 1) + '"><td data-field="' + ($tr.data("index") + 1) + '" align="center" data-content="" data-minwidth="100"><div class="layui-table-cell laytable-cell-1-' + ($tr.data("index") + 1) + '"> <input type="checkbox" name="gradeStatus" lay-filter="gradeStatus" lay-skin="switch" lay-text="启用|禁用" checked=""><div class="layui-unselect layui-form-switch layui-form-onswitch" lay-skin="_switch"><em>启用</em><i></i></div></div></td></tr>');
                form.render();
            }else{
                layer.alert("模版中由于图标数量的原因，只支持到vip10，实际开发中可根据实际情况修改。当然也不要忘记增加对应等级的颜色。",{maxWidth:300});
            }
        });

        //控制表格编辑时文本的位置【跟随渲染时的位置】
        $("body").on("click",".layui-table-body.layui-table-main tbody tr td",function(){
            $(this).find(".layui-table-edit").addClass("layui-"+$(this).attr("align"));
        });

    })
</script>
</body>
</html>