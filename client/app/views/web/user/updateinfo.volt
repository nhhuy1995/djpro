{#<link href="/web/css/datepicker.css" rel="stylesheet" type="text/css" />#}
{#<script src="/web/js/bootstrap-datepicker.js"></script>#}
{#<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>#}
<link rel="stylesheet" type="text/css" href="/web/css/jquery.datepick.css">
<script type="text/javascript" src="/web/js/jquery.plugin.js"></script>
<script type="text/javascript" src="/web/js/jquery.datepick.js"></script>
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
                                    <h4 class="modal-title" id="myModalLabel">Đổi thông tin cá nhân</h4>
                                </div>
                                <div class="modal-body">
                                    {% if msg['status']==0 %}
                                        <div style="color: red;text-align: center;font-weight: bold;">{{ msg['msg'] }}</div>
                                    {% else %}
                                        <div style="color: green;text-align: center;font-weight: bold;">{{ msg['msg'] }}</div>
                                    {% endif %}
                                    <form action="" method="post" class="cd-form">
                                        <p class="fieldset">
                                            <i class="fa fa-user"></i>
                                            <input class="full-width has-padding has-border" name="name"
                                                   disabled="disabled" style="background-color: white;"
                                                   id="signup-username" type="text" value="{{ object.username }}"
                                                   placeholder="Tên đăng nhập">
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <i class="fa fa-envelope"></i>
                                            <input class="full-width has-padding has-border" name="email"
                                                   disabled="disabled" style="background-color: white;"
                                                   id="signup-email" type="email" value="{{ object.email }}"
                                                   placeholder="Email đăng ký">
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <i class="fa fa-user"></i>
                                            <input class="full-width has-padding has-border"
                                                   value="{{ object.fullname }}" name="fullname"
                                                   id="signup-username" type="text" placeholder="Họ và tên">
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <i class="fa fa-bank"></i>
                                            <input class="full-width has-padding has-border" name="address"
                                                   id="signup-username" type="text" value="{{ object.address }}"
                                                   placeholder="Địa chỉ">
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <i class="fa fa-phone"></i>
                                            <input class="full-width has-padding has-border" name="phone"
                                                   id="signup-username" value="{{ object.phone }}" type="text"
                                                   placeholder="Số điện thoại">
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        {#<p class="fieldset">
                                            <i class="fa fa-birthday-cake"></i>
                                            <input class="full-width has-padding has-border" name="birthday"
                                                   id="datepicker" value="{{date('d/m/Y',object.birthday) }}" type="text"
                                                   placeholder="Ngày sinh">
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>#}
                                        <p>

                                        <p class="fieldselect col-md-3" style="padding: 0px;margin: 0px;">
                                            <i class="fa fa-birthday-cake"></i>
                                            <select name="days" class="full-width has-padding has-border">
                                                <option value="">Ngày</option>
                                                {% for key in 1..31 %}
                                                    <option value="{{ key }}" {% if object.days == key %} selected {% endif %}>{{ key }}</option>
                                                {% endfor %}
                                            </select>
                                        </p>
                                        <p class="fieldselect col-md-3" style="padding: 0px;margin: 0px">
                                            <i class="fa fa-birthday-cake"></i>
                                            <select id="" name="month" class="full-width has-padding has-border">
                                                <option value="">Tháng</option>
                                                {% for key in 1..12 %}
                                                    <option value="{{ key }}" {% if object.month == key %} selected {% endif %}>{{ key }}</option>
                                                {% endfor %}
                                            </select>
                                        </p>
                                        <p class="fieldselect col-md-3" style="padding: 0px;margin: 0px">
                                            <i class="fa fa-birthday-cake"></i>
                                            <select id="" name="year" class="full-width has-padding has-border">
                                                <option value="">Năm</option>
                                                {% for k in 1905..2016 %}
                                                    <option value="{{ k }}" {% if object.year == k %} selected {% endif %}>{{ k }}</option>
                                                {% endfor %}
                                            </select>
                                        </p>
                                        </p>
                                        <p style="clear: both"></p>

                                        <p class="fieldset">
                                            <i class="fa fa-facebook"></i>
                                            <input class="full-width has-padding has-border" name="facebook"
                                                   id="signup-username" type="text" value="{{ object.facebook }}"
                                                   placeholder="Facebook">
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <i class="fa fa-yahoo"></i>
                                            <input class="full-width has-padding has-border" name="yahoo"
                                                   id="signup-username" type="text" value="{{ object.yahoo }}"
                                                   placeholder="Yahoo! Messenger">
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <i class="fa fa-skype"></i>
                                            <input class="full-width has-padding has-border" name="skype"
                                                   id="signup-username" type="text" value="{{ object.skype }}"
                                                   placeholder="Skype">
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <i class="fa fa-briefcase"></i>
                                            <input class="full-width has-padding has-border" name="job"
                                                   id="signup-username" type="text" value="{{ object.job }}"
                                                   placeholder="Nghề nghiệp">
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <i class="fa fa-gamepad"></i>
                                            <input class="full-width has-padding has-border" name="hobby"
                                                   id="signup-username" type="text" value="{{ object.hobby }}"
                                                   placeholder="Sở thích">
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <input name="sex" {% if object.sex == 'NA' %}checked {% endif %}
                                                   id="signup-username" type="radio" value="NA"> N/A&nbsp;
                                            <input name="sex" {% if object.sex == 'male' %}checked {% endif %}
                                                   id="signup-username" type="radio" value="male"> Nam &nbsp;
                                            <input name="sex" {% if object.sex == 'female' %}checked {% endif %}
                                                   id="signup-username" type="radio" value="female"> Nữ

                                        </p>
                                        <label>Ảnh đại diện</label>

                                        <p class="fieldset">
                                            <input type="file" name="file_upload" id="file_upload_avatar"/>
                                            <input type="hidden" name="priavatar" id="priavatar"
                                                   value="{{ object.priavatar }}"/>

                                        <p>
                                            <img src="{{ object.priavatar }}" id="previewavatar"
                                                 style="max-width: 350px;"/>
                                        </p>
                                        {#<p class="help-block">Chọn ảnh PNG, JPG, JPEG, GIF (Khuyến khích ảnh 555x260px)</p>#}
                                        <p>

                                        <p class="fieldset">
                                            <input class="btn-edit" type="submit" value="Cập nhật">
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
<script type="text/javascript">
    $(document).ready(function () {
//        $("#datepicker").datepicker({
//            autoclose: true,
//            format: 'dd/mm/yyyy',
//            todayHighlight: true,
//        });
        $('#datepicker').datepick({
            dateFormat: 'dd/mm/yyyy',
        });
    });
    //Upload File
    $('#file_upload_avatar').uploadify({
        'formData'      : {'img_type' : 'user'},
        'swf': '/web/plugin/uploadify/uploadify.swf',
        'uploader': 'http://s1.download.stream.djscdn.com/upload_image',
        'fileTypeExts': '*.jpg; *.png; *.gif',
        'onUploadSuccess': function (file, data, response) {
            var obj = JSON.parse(data);
            if (obj.status == 200) {
                $('#priavatar').val(obj.path[0]);
                $('#previewavatar').attr('src', obj.path[0]);
                $('#previewavatar').fadeIn();
            } else {
                alert(obj.mss);
            }
        }
    });
</script>