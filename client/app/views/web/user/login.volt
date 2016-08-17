{% include '/layouts/header.volt' %}
<div id="content">


    <div class="artists">
        <div class="container">
            <div class="row">

                <div class="col-ldh-9 col-sm-8">
                    <!-- form-đăng-nhập -->
                    <div tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Đăng nhập</h4>
                                </div>
                                <div class="modal-body">
                                    <div style="color: red;text-align: center;font-weight: bold;">{{ msg }}</div>
                                    <form class="cd-form" method="post">
                                        <p class="fieldset">
                                            <i class="fa fa-envelope"></i>
                                            <input class="full-width has-padding has-border" id="signin-email"
                                                   type="text" name="username" placeholder="Tên đăng nhập hoặc Email">
                                            {#<span class="cd-error-message">Email không hợp lệ!</span>#}
                                        </p>

                                        <p class="fieldset">
                                            <i class="fa fa-key"></i>
                                            <input class="full-width has-padding has-border" name="password"
                                                   id="signin-password" type="text" placeholder="Mật khẩu">
                                            <a href="#0" class="hide-password">Hide</a>
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <input type="checkbox" id="remember-me" checked>
                                            <label for="remember-me">Nhớ mật khẩu</label>
                                            <label for="remember-me" style="float: right;"><a
                                                        href="/quen-mat-khau.html">Quên mật khẩu</a> </label>
                                        </p>

                                        <p class="fieldset">
                                            <input class="full-width" type="submit" value="Đăng nhập">
                                        </p>

                                        <div class="social-login">
                                            <span>Hoặc sử dụng:</span>
                                            <ul>
                                                <li><a href="#"><i class="fa fa-facebook"></i>facebook</a></li>
                                                <li><a href="#"><i class="fa fa-google-plus"></i>Google +</a></li>
                                            </ul>
                                        </div>
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