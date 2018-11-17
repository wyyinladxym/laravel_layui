layui.use(['layer', 'jquery'], function () {
    var layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        complete: function (xhr, strStatus) {
            if (xhr.responseJSON.loginStatus == 0) {
                layer.msg(xhr.responseJSON.msg, {icon: 2});
                setTimeout(function () {
                    window.location.href = xhr.responseJSON.url;
                }, 1500);

            }
        }
    });
})
