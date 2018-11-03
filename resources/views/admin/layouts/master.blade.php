<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>@yield('title')</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{asset('/frame/layui/css/layui.css')}}" media="all" />
	<link rel="stylesheet" href="{{asset('/css/admin/public.css')}}" media="all" />
</head>
<body class="childrenBody">
	@section('content')
	@show
	<script type="text/javascript" src="{{asset('/frame/layui/layui.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/admin/public.js')}}"></script>
	@yield('script')
</body>
</html>