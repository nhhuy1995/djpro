$(document).ready(function(){
    $('#uname').focus(function(){
        $('#checkAcount').hide();
    });

    $('#uname').blur(function(){
        $('#checkAcount').show();
        $('#checkAcount').css({'display' : 'inline'});
        console.log(1);
        var dataString =
        {
            act: 'checkunameexist',
            username : $('#uname').val()
        };
        if($('#uname').val().length>=5){
            $.ajax({
                type: "POST",
                beforeSend:function(){$('#checkAcount').html("<img src=images/misc/loading.png border=0 alt=Loading />");},
                url: "ajaxprocess.se?",
                data: dataString,
                success: function(result) {
                    if(result.status==1) $('#checkAcount').html("<font color=red>Tên đăng nhập đã tồn tại, vui lòng chọn tên khác !</font>");
                    else $('#checkAcount').html('<font color=green>Tên đăng nhập hợp lệ !</font>');
                }
            });
        }
    });

    $('#uemail').focus(function(){
        $('#checkEmail').hide();
    });

    $('#uemail').blur(function(){
        $('#checkEmail').show();
        $('#checkEmail').css({'display' : 'inline'});
        var dataString = {
            act: 'checkemailexist',
            email: $('#uemail').val()
        };
        var checkEmail = IsEmail($('#uemail').val());
        if(checkEmail && $('#uemail').val().length>=5){
            $.ajax({
                type: "POST",
                beforeSend:function(){ $('#checkEmail').html("<img src=/web/asset/themes/black/images/icon/loading.png border=0 alt=Loading />");},
                url: "ajaxprocess.se?",
                data: dataString,
                success: function(result) {
                    if(result.status==1) $('#checkEmail').html("<font color=red>Email này đã được đăng ký, hãy chọn Email khác !</font>");
                    else $('#checkEmail').html('<font color=green>Địa chỉ email hợp lệ !</font>');
                }
            });
        }
    });
});

function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}