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

//改变二位数组键名
function changeKey($data, $id_field = 'id')
{
    $new_array = [];
    foreach ((array)$data as $val) {
        $new_array[$val[$id_field]] = $val;
    }
    unset($data);
    return $new_array;
}

//传入键为id的二位数组返回树结构
function getTree($data = [], $p_field = 'parent_id')
{
    $items = changeKey($data);
    unset($data);
    $tree = array(); //格式化好的树
    foreach ($items as $item) {
        if (isset($items[$item[$p_field]])) {
            $items[$item[$p_field]]['children'][] = &$items[$item['id']];
        } else {
            $tree[] = &$items[$item['id']];
        }
    }
    return $tree;
}

//递归方式获取树结构html
function getTreeHtml(&$array, $p_id = 0, $level = 0, $sign = '-|', $p_field = 'parent_id')
{
    $arr = array();
    foreach ($array as $k => $v) {
        if ($v[$p_field] == $p_id) {
            $v['level'] = $level;
            $html = $level ? str_repeat('&nbsp;&nbsp;&nbsp;', $level) . '|----' : '';
            $v['html'] = $html . $v['title'];
            $arr[] = $v;
            unset($array[$k]);
            $arr = array_merge($arr, getTreeHtml($array, $v['id'], $level + 2));
        }
    }
    return $arr;
}

