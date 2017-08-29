$(function () {
    $('.clearCache').on('click',function () {
        $.ajax({
            url : 'index/clearCache',
            type: 'post',
            dataType:'json',
            success:function(result){
                if(result.code !== 200){
                    toastr.warning(result.msg);
                }else{
                    toastr.success(result.msg);
                }
            }
        });
    });
});