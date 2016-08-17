{% include '/layouts/header.volt' %}
<div id="content">


    <div class="artists">
        <div class="container">
            <div class="row">

                <div class="col-ldh-9 col-sm-8">
                    <!-- form-đổi mật khẩu -->
                    <div tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Đổi mật khẩu</h4>
                                </div>
                                <div class="modal-body">
                                    {% if msg['status']==0 %}
                                        <div style="color: red;text-align: center;font-weight: bold;">{{ msg['msg'] }}</div>
                                    {% else %}
                                        <div style="color: green;text-align: center;font-weight: bold;">{{ msg['msg'] }}</div>
                                    {% endif %}
                                    <form class="cd-form" method="post">
                                        <p class="fieldset">
                                            <i class="fa fa-key"></i>
                                            <input class="full-width has-padding has-border passwordcurrent"  data-passwordcurrent="{{ session['password'] }}" onkeypress="checkPasswordCurrent(this)"
                                                   name="passwordcurrent" type="password" placeholder="Mật khẩu cũ">
                                            <a href="javascript:void(0)" class="hide-password">Hide</a>
                                        </p>
                                        <span id="error_passwordcurrent"></span>
                                        <p class="fieldset">
                                            <i class="fa fa-key"></i>
                                            <input class="full-width has-padding has-border" id="password" onkeyup="checkPassword(this)"
                                                   name="password" type="password" placeholder="Mật khẩu mới">
                                            <a href="javascript:void(0)" class="hide-password">Hide</a>
                                        </p>
                                        <span id="error_password"></span>
                                        <p class="fieldset">
                                            <i class="fa fa-key"></i>
                                            <input class="full-width has-padding has-border" id="repassword" onkeyup="checkrePassword(this)"
                                                   name="repassword" type="password" placeholder="Nhập lại mật khẩu mới">
                                            <a href="javascript:void(0)" class="hide-password">Hide</a>
                                        </p>
                                        <span id="error_repassword"></span>
                                        <p class="fieldset">
                                            <input class="btn-edit" type="submit" value="Thay đổi">
                                            <input class="btn-edit" type="reset" onclick="resetText();" value="Làm lại">
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {% include '/layouts/siderbar_right.volt' %}
            </div>
        </div>
    </div>


</div>

<!--===================footer=====================-->
{% include '/layouts/footer.volt' %}
<script>
    function resetText(){
        $('.passwordcurrent').removeAttr('style');
        $('#error_passwordcurrent').hide();
        $('#password').removeAttr('style');
        $('#error_password').hide();
        $('#repassword').removeAttr('style');
        $('#error_repassword').hide();
    }
    var t = 400;
    var thread;
    function checkPasswordCurrent(obj) {
        clearTimeout(thread);
        thread = setTimeout(function () {
            var password = $(obj).val();
            var pass_md5 = md5(md5(password));
            var password_current = $(obj).data('passwordcurrent');
            if (password_current != pass_md5) {
                $('#error_passwordcurrent').show();
                $('#error_passwordcurrent').html('Mật khẩu cũ không đúng!');
                $(obj).css('border', '1px solid red');
            } else {
                $('#error_passwordcurrent').hide();
                $(obj).removeAttr('style');
            }
        }, t)
    }
    function checkPassword(obj) {
        clearTimeout(thread);
        thread = setTimeout(function () {
            var password = $(obj).val();
                if (password.length <= 5) {
                    $('#error_password').show();
                    $('#error_password').html('Mật khẩu mới phải từ 6 kí tự trở lên!');
                    $(obj).css('border', '1px solid red');
                } else {
                    $('#error_password').hide();
                    $(obj).removeAttr('style');
                }
        }, t)
    }
    function checkrePassword(obj) {
        clearTimeout(thread);
        thread = setTimeout(function () {
            var password = $("#password").val();
            var repassword = $(obj).val();
            if (password != repassword) {
                $('#error_repassword').show();
                $('#error_repassword').html('Mật khẩu không trùng khớp');
                $(obj).css('border', '1px solid red');
            }
            else if(repassword.length <= 5){
                $('#error_repassword').show();
                $('#error_repassword').html('Nhập lại mật khẩu phải từ 6 kí tự trở lên!');
                $(obj).css('border', '1px solid red');
            }
            else {
                $('#error_repassword').hide();
                $(obj).removeAttr('style');
            }
        }, t)
    }
</script>