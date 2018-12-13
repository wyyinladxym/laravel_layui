layui.use(['layer', 'jquery'], function () {
    var layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        complete: function (xhr, strStatus) {
            if (xhr.responseJSON.loginStatus != undefined && xhr.responseJSON.loginStatus == 0) {
                layer.msg(xhr.responseJSON.msg, {icon: 2});
                setTimeout(function () {
                    window.location.href = xhr.responseJSON.url;
                }, 1500);

            }
        }
    });
})


//时间格式化
function filterTime(m) {
    return m < 10 ? '0' + m : m
}
//时间戳转换
function formatData(time_stamp = '') {
    var time_stamp = time_stamp ? parseInt(time_stamp)*1000 :  new Date().getTime();
    var time = new Date(time_stamp);
    return time.getFullYear() + '-' + filterTime(time.getMonth() + 1) + '-' + filterTime(time.getDate()) + ' ' + filterTime(time.getHours()) + ':' + filterTime(time.getMinutes()) + ':' + filterTime(time.getSeconds());
}
