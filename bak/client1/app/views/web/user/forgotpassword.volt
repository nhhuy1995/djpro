{% include '/layouts/header.volt' %}

<div id="content">


    <div class="artists">
        <div class="container">
            <div class="row">

                <div class="col-ldh-9 col-sm-8">
                    <!-- form-quên mật khẩu -->
                    <div tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Quên mật khẩu</h4>
                                </div>
                                <div class="modal-body">
                                    <p class="cd-form-message">Nếu bạn quên mật khẩu, chỉ cần gõ địa chỉ email của bạn
                                        chúng tôi sẽ gửi link để khôi phục lại mật khẩu.</p>
                                    {% if error['status']==0 %}
                                        <div style="color: red;text-align: center;font-weight: bold;">{{ error['msg'] }}</div>
                                    {% else %}
                                        <div style="color: green;text-align: center;font-weight: bold;">{{ error['msg'] }}</div>
                                    {% endif %}
                                    <form class="cd-form" method="post">
                                        <p class="fieldset">
                                            <i class="fa fa-envelope"></i>
                                            <input class="full-width has-padding has-border" name="email"
                                                   id="reset-email" type="email" placeholder="Email">
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <input class="full-width has-padding" type="submit"
                                                   value="Khôi phục mật khẩu">
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