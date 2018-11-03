
//设置ajax请求表头添加X-CSRF-TOKEN
   var  start_token =  function(){
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
   }
