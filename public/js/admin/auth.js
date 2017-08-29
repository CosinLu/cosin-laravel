$(function(){

    $(document).on('click','.selectPer',function(){
        var _this = $(this)
        var childVal = _this.closest('div').next('div').find('input')
        if(_this.is(':checked')){
            childVal.each(function(){
                $(this).prop('checked',true)
            })
        }else{
            childVal.each(function(){
                $(this).prop('checked',false)
            })
        }
    });

});


function editRole(id){
    $('#editRole').modal();
    $.ajax({
        url : 'auth/editRole',
        type: 'post',
        data:{
            id:id
        },
        success:function(result){
            if(result.status == 500){
                toastr.warning(result.msg)
                return false
            }
            $('.edit_role').html(result)
        }
    });
}