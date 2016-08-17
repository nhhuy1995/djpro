{% include '/layouts/header.volt' %}

<div id="content">


    <div class="artists">
        <div class="container">
            <div class="row">

                <div class="col-ldh-9 col-sm-8">

                    <!-- form-đăng-ký -->
                    <div tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Khôi phục mật khẩu</h4>
                                </div>
                                <div class="modal-body">
                                    {% if error['status']==0 %}
                                        <div style="color: red;text-align: center;font-weight: bold;">{{ error['msg'] }}</div>
                                    {% else %}
                                        <div style="color: green;text-align: center;font-weight: bold;">{{ error['msg'] }}</div>
                                    {% endif %}
                                    <form action="" method="post" class="cd-form">
                                        {#<p class="fieldset">
                                            <i class="fa fa-key"></i>
                                            <input class="full-width has-padding has-border" name="password"
                                                   id="signup-password" type="password" placeholder="Mật khẩu mới">
                                            <a href="javascript:void(0)" class="hide-password">Hide</a>
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <i class="fa fa-key"></i>
                                            <input class="full-width has-padding has-border" name="re-password"
                                                   id="signup-password" type="password" placeholder="Nhập lại mật khẩu">
                                            <a href="javascript:void(0)" class="hide-password">Hide</a>
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>#}
                                        <p class="fieldset">
                                            <i class="fa fa-key"></i>
                                            <input type="password" placeholder="Mật khẩu" name="password" onkeypress="checkPassword_resetpass(this)" id="password_reset" class="full-width has-padding has-border">
                                            <a class="hide-password" href="javascript:void(0)">Hide</a>
                                        </p>
                                        <span id="error_password_reset" style="color: red;"></span>
                                        <p class="fieldset">
                                            <i class="fa fa-key"></i>
                                            <input type="password" placeholder="Nhập lại mật khẩu" name="re-password" onkeypress="checkrePassword_resetpass(this)" id="repassword_reset" class="full-width has-padding has-border">
                                            <a class="hide-password" href="javascript:void(0)">Hide</a>
                                        </p>
                                        <span id="error_repassword_reset" style="color: red;"></span>
                                        <p class="fieldset">
                                            <input class="btn-edit" type="submit" value="Xác nhận">
                                            <input class="btn-edit" type="reset" value="Làm lại">
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
    function checkPassword_resetpass(obj) {
        clearTimeout(thread);
        thread = setTimeout(function () {
            var password = $(obj).val();
            if (password.length < 6) {
                $('#error_password_reset').show();
                $('#error_password_reset').html('Mật khẩu phải từ 6 kí tự trở lên!');
                $(obj).css('border', '1px solid red');
            } else {
                $('#error_password_reset').hide();
                $(obj).removeAttr('style');
            }
        }, t)
    }
    function checkrePassword_resetpass(obj) {
        clearTimeout(thread);
        thread = setTimeout(function () {
            var password = $("#password_reset").val();
            var repassword = $(obj).val();
            if (password != repassword) {
                $('#error_repassword_reset').show();
                $('#error_repassword_reset').html('Mật khẩu không trùng khớp');
                $(obj).css('border', '1px solid red');
            }
            else if (repassword.length < 6) {
                $('#error_repassword_reset').show();
                $('#error_repassword_reset').html('Nhập lại mật khẩu phải từ 6 kí tự trở lên!!');
                $(obj).css('border', '1px solid red');
            }
            else {
                $('#error_repassword_reset').hide();
                $(obj).removeAttr('style');
            }
        }, t)
    }
</script>