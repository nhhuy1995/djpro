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
                                    <h4 class="modal-title" id="myModalLabel">Đăng ký</h4>
                                </div>
                                <div class="modal-body">
                                    <div style="color: red;text-align: center;font-weight: bold;">{{ msg }}</div>
                                    <form action="" method="post" class="cd-form">
                                        <input type="hidden" name="capcha-random" value="{{ capcha }}">

                                        <p class="fieldset">
                                            <i class="fa fa-user"></i>
                                            <input class="full-width has-padding has-border"
                                                   onkeyup="checkUsername(this);" name="name" id="signup-username"
                                                   type="text" placeholder="Tên đăng nhập">
                                            <span id="error_username"
                                                  style="color: red; font-weight: bold; font-size: 13px;">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <i class="fa fa-envelope"></i>
                                            <input class="full-width has-padding has-border" name="email"
                                                   onkeyup="checkEmail(this);" id="signup-email" type="email1"
                                                   placeholder="Email đăng ký">
                                            <span id="error_email"
                                                  style="color: red; font-weight: bold; font-size: 13px;">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <i class="fa fa-key"></i>
                                            <input class="full-width has-padding has-border" name="password"
                                                   id="signup-password" type="text" placeholder="Mật khẩu">
                                            <a href="#0" class="hide-password">Hide</a>
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <i class="fa fa-key"></i>
                                            <input class="full-width has-padding has-border" name="re-password"
                                                   id="signup-password" type="text" placeholder="Nhập lại mật khẩu">
                                            <a href="#0" class="hide-password">Hide</a>
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <i class="fa fa-lock"></i>
                                            <input style="width:200px" class="full-width has-padding has-border"
                                                   name="capcha" id="signup-password" type="text"
                                                   placeholder="Mã bảo mật">
                                            {#<img src="/web/skins/images/capcha.jpg" alt=""/>#}
                                            <span style="background-color: #01A050;padding: 5px 20px 5px 20px;"><i
                                                        style="color: white;">{{ capcha }}</i></span>
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <input type="checkbox" id="accept-terms">
                                            <label for="accept-terms">Tôi đồng ý với các <a href="#">Điều khoản</a> trên
                                                website</label>
                                        </p>

                                        <p class="fieldset">
                                            <input class="btn-edit" type="submit" value="Đăng ký">
                                            <input class="btn-edit" type="reset" value="Làm lại">
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {% include 'layouts/siderbar_right.volt' %}
            </div>
        </div>
    </div>


</div>

<!--===================footer=====================-->

{% include '/layouts/footer.volt' %}
