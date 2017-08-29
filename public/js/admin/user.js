$(function () {
   $('.add_manager').on('click',function () {
       $('.manager_form').removeClass('hidden');
   });

   $('.closed').on('click',function () {
      $('.manager_form').addClass('hidden');
   });

   $('.submit-add').on('click',function () {
       var username = $("input[name='Admin[username]']").val();
       var password = $("input[name='Admin[password]']").val();
       if(username == '' || username == null){
           $('.username-tips').html('用户名不可为空')
           return false
       }else{
           $('.username-tips').removeClass('text-danger')
           $('.username-tips').addClass('text-success')
           $('.username-tips').html('用户名规则正确')
       }
       if(username.length <4){
           $('.username-tips').html('用户名不能少于五位数')
           return false
       }else{
           $('.username-tips').removeClass('text-danger')
           $('.username-tips').addClass('text-success')
           $('.username-tips').html('用户名规则正确')
       }
       if(password == '' || password == null){
           $('.password-tips').html('密码不可为空')
           return false
       }else{
           $('.password-tips').removeClass('text-danger')
           $('.password-tips').addClass('text-success')
           $('.password-tips').html('密码规则正确')
       }
       if(password.length <4){
           $('.password-tips').html('密码不能少于五位数')
           return false
       }else{
           $('.password-tips').removeClass('text-danger')
           $('.password-tips').addClass('text-success')
           $('.usernpasswordame-tips').html('密码规则正确')
       }
   });

});
function delManager(id){
    $('#del').modal();
    $('.tips-text').html('确定删除ID为'+id+'的管理员?');
    $('.del-manager').on('click',function(){
        $.ajax({
            url : 'admin/del',
            type: 'post',
            data:{
                id:id,
            },
            dataType:'json',
            success:function(result){
                if(result.code !== 200){
                    toastr.warning(result.msg);
                    $('#del').modal('hide');
                    window.location.reload()
                }else{
                    toastr.success(result.msg);
                    $('#del').modal('hide');
                    window.location.reload()
                }
            }
        });
    });
}

function editManager(id){
    $('#edit').modal();
    $.ajax({
        url : 'admin/edit',
        type: 'get',
        data:{
            id:id,
        },
        dataType:'json',
        success:function(result){
            if(result.status == 200){
                $('.username').val(result.admins.username)
                var checked
                $.each(result.roles,function (index,value) {
                    if(result.roleuser != null){
                        checked = result.roleuser.role_id == value.id ? 'selected = "selected"' : '';
                    }
                    var html = "<option "+checked+" value='"+value.id+"'>"+value.display_name+"</option>";
                    $('.role-name').append(html)
                })
            }else{
                toastr.warning(result.msg)
                return false
            }
        }
    });
    $('.edit-manager').on('click',function(){
        var password = $('.passwd').val()
        var username = $('.username').val()
        var role_name = $('.role-name').val()
        if(password == null || password == ''){
            $('.passwd-tips').html('密码不可为空');
            return false;
        }else if(password.length < 5){
            $('.passwd-tips').html('密码不可小于五位数');
            return false;
        }else if(username == null || username == ''){
            $('.uname-tips').html('用户名不可为空');
            return false;
        }else if(username.length < 5){
            $('.uname-tips').html('用户名不可少于五个字符');
            return false;
        }else{
            $.ajax({
                url : 'admin/edit',
                type: 'post',
                data:{
                    id:id,
                    password:password,
                    username:username,
                    role_id:role_name,
                },
                dataType:'json',
                success:function(result){
                    if(result.code !== 200){
                        toastr.warning(result.msg);
                        $('#edit').modal('hide');
                        window.location.reload()
                    }else{
                        toastr.success(result.msg);
                        $('#edit').modal('hide');
                        window.location.reload()
                    }
                }
            });
        }
    });
}