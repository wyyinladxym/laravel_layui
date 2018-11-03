<?php

//返回信息
function resultInfo($msg = '', $status = 0, $data = '', $url = '')
{
    if (is_numeric($msg)) {
        $status = $msg;
        $msg = '';
    }
    if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
        $url = $_SERVER["HTTP_REFERER"];
    } elseif ('' !== $url) {
        $url = preg_match('/^(https?:|\/)/', $url) ? $url : $url;
    }
    $result = [
        'status' => $status,
        'msg' => $msg,
        'url' => $url,
        'data' => $data
    ];
    return $result;
}

//返回列表信息
function resultList($data = [], $count = 0, $code = 0, $msg = '')
{
    $result = [
        'code' => $code,
        'msg' => $msg,
        'count' => $count,
        'data' => $data
    ];
    return $result;
}

