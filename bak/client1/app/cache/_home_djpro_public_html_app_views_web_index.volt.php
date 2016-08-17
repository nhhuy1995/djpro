<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta property="og:url" content="<?php echo $DOMAIN; ?><?php echo $object->link; ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?php echo $object->name; ?>"/>
    <meta property="og:description" content="<?php echo $object->description; ?>"/>
    <meta property="og:image" content="<?php echo $DOMAIN; ?><?php echo $object->priavatar; ?>"/>
    <title><?php echo (empty($title) ? ('Trang chủ') : ($title)); ?></title>
    <link rel="stylesheet" href="/web/skins/style.css" type="text/css" media="all">
    <link rel="stylesheet" href="/web/skins/responsive.css" type="text/css" media="all">
    <link rel="stylesheet" href="/web/skins/font-awesome.css" type="text/css" media="all">
    <link rel="stylesheet" href="/web/skins/menu-clean.css"/>
    <link rel="stylesheet" href="/web/skins/owl.carousel.css"/>
    <link rel="stylesheet" href="/web/skins/login.css"/>
    <link rel="stylesheet" href="/web/skins/tabs.css"/>
    <link rel="stylesheet" href="/web/css/style.css"/>
    <link rel="stylesheet" href="/web/skins/jplayer.css"/>
    <link rel="stylesheet" href="/web/plugin/jquery.select2/css/select2.min.css"/>
    
    <script type="text/javascript" src="/web/js/jquery.min.js"></script>
    <script type="text/javascript" src="/web/js/customer.js"></script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <script type="text/javascript" src="/web/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/web/js/jquery.smartmenus.js"></script>
    <script type="text/javascript" src="/web/js/owl.carousel.js"></script>
    <script type="text/javascript" src="/web/js/jquery.sticky.js"></script>
    <script type="text/javascript" src="/web/plugin/jquery.select2/js/select2.min.js"></script>
    <script type="text/javascript" src="/web/js/dj_core.js"></script>
    <script>
        $(window).load(function () {
            $("#sticky-menu").sticky({topSpacing: 0});
        });
    </script>
    <!-- Start js-scroller-->
    <script type="text/javascript" src="/web/js/jquery.nanoscroller.js"></script>
    <script type="text/javascript">
        $(function(){

            $('.nano').nanoScroller({
                preventPageScrolling: true
            });

        });
    </script>
    <script src="/web/js/login.js"></script>
    <!-- Gem jQuery -->
    <script type="text/javascript" src="/web/plugin/uploadify/jquery.uploadify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/web/plugin/uploadify/uploadify.css"/>
</head>

<body>
<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<?php echo $this->getContent(); ?>

<div class="cd-user-modal"> <!-- modal form, login-singup-dangnhac -->
    <div class="cd-user-modal-container">
        <ul class="cd-switcher">
            <li><a href="javascript:void(0)">Đăng nhập</a></li>
            <li><a href="javascript:void(0)">Đăng ký</a></li>
        </ul>

        <div id="cd-login"> <!-- log in form -->
            <form class="cd-form cd-login" method="post" action="/dang-nhap.html">
                <p id="msg_login" style="color: red;font-weight: bold;text-align: center;"></p>

                <p class="fieldset">
                    <i class="fa fa-envelope"></i>
                    <input class="full-width has-padding has-border" id="signin-email" name="username"
                           placeholder="Tên đăng nhập hoặc Email">
                    <span class="cd-error-message">Email không hợp lệ!</span>
                </p>

                <p class="fieldset">
                    <i class="fa fa-key"></i>
                    <input class="full-width has-padding has-border" id="signin-password" type="password" name="password"
                           placeholder="Mật khẩu">
                    <a href="javascript:void(0)" class="hide-password">Hide</a>
                    <span class="cd-error-message">Error message here!</span>
                </p>

                <p class="fieldset">
                    <input type="checkbox" id="remember-me" checked>
                    <label for="remember-me">Nhớ mật khẩu</label>
                </p>

                <p class="fieldset">
                    <input class="full-width" type="submit" onclick="login();" name="submit" value="Đăng nhập">
                </p>

                <div class="social-login">
                    <span>Hoặc sử dụng:</span>
                    <ul>
                        <li><a href="<?php echo $urllogin_fb; ?>"><i class="fa fa-facebook"></i>facebook</a></li>
                        
                        <li><a href="<?php echo $urllogin_google; ?>"><i class="fa fa-google-plus"></i>Google +</a></li>
                    </ul>
                </div>
            </form>
            <p class="cd-form-bottom-message"><a href="javascript:void(0)">Quên mật khẩu?</a></p>
            <!-- <a href="javascript:void(0)0" class="cd-close-form">Close</a> -->
        </div>
        <!-- cd-login -->
        <div id="cd-signup"> <!-- sign up form -->
            <form class="cd-form cd-signup">
                <input type="hidden" id="capcha-random" name="capcha-random" value="">

                <p class="msg_register " style="color: red;font-weight: bold;text-align: center;"></p>

                <p class="fieldset">
                    <i class="fa fa-user"></i>
                    <input class="full-width has-padding has-border" id="usernameregister"
                           onkeyup="checkUsername_register(this);" name="name" id="signup-username"
                           type="text" placeholder="Tên đăng nhập">
                </p>
                <span id="error_usernameregister"></span>
                <p class="fieldset">
                    <i class="fa fa-user"></i>
                    <input type="text" placeholder="Họ và tên" id="" name="fullname" class="full-width has-padding has-border">
                    <span class="cd-error-message">Error message here!</span>
                </p>

                <p class="fieldset">
                    <i class="fa fa-envelope"></i>
                    <input class="full-width has-padding has-border" name="email" id="emailregister"
                           onkeyup="checkEmail_register(this);" id="signup-email" type="email1"
                           placeholder="Email đăng ký">
                </p>
                <span id="error_emailregister"></span>

                <p class="fieldset">
                    <i class="fa fa-key"></i>
                    <input class="full-width has-padding has-border" id="password" onkeypress="checkPassword_register(this)" name="password" id="signup-password" type="password"
                           placeholder="Mật khẩu">
                    <a href="javascript:void(0)" class="hide-password">Hide</a>
                </p>
                <span id="error_password"></span>
                <p class="fieldset">
                    <i class="fa fa-key"></i>
                    <input class="full-width has-padding has-border"  id="repassword" onkeypress="checkrePassword_register(this)" name="repassword" id="signuppassword" type="password"
                           placeholder="Nhập lại mật khẩu">
                    <a href="javascript:void(0)" class="hide-password">Hide</a>
                </p>
                <span id="error_repassword"></span>
                <p style="clear: both"></p>
                <p class="fieldselect col-md-3" style="padding: 0px;margin: 0px;">
                    <i class="fa fa-birthday-cake"></i>
                    <select name="days" class="full-width has-padding has-border">
                        <option value="">Ngày</option>
                        <?php foreach (range(1, 31) as $key) { ?>
                            <option value="<?php echo $key; ?>" <?php if ($object->days == $key) { ?> selected <?php } ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </p>
                <p class="fieldselect col-md-3" style="padding: 0px;margin: 0px">
                    <i class="fa fa-birthday-cake"></i>
                    <select id="" name="month" class="full-width has-padding has-border">
                        <option value="">Tháng</option>
                        <?php foreach (range(1, 12) as $key) { ?>
                            <option value="<?php echo $key; ?>" <?php if ($object->month == $key) { ?> selected <?php } ?>><?php echo $key; ?></option>
                        <?php } ?>
                    </select>
                </p>
                <p class="fieldselect col-md-3" style="padding: 0px;margin: 0px">
                    <i class="fa fa-birthday-cake"></i>
                    <select id="" name="year" class="full-width has-padding has-border">
                        <option value="">Năm</option>
                        <?php foreach (range(1905, 2016) as $k) { ?>
                            <option value="<?php echo $k; ?>" <?php if ($object->year == $k) { ?> selected <?php } ?>><?php echo $k; ?></option>
                        <?php } ?>
                    </select>
                </p>
                </p>
                <p style="clear: both"></p>
                <p class="fieldset">
                    <input name="sex" checked id="signup-username" type="radio" value="NA"> N/A&nbsp;
                    <input name="sex" id="signup-username" type="radio" value="male"> Nam &nbsp;
                    <input name="sex" id="signup-username" type="radio" value="female"> Nữ

                </p>
                <div class="wrap_capcha">
                    <div id="capcha"><i style="color: white;"></i>
                    </div>
                    <div id="refresh_capcha">
                        <a href="javascript:void(0)" onclick="randomCaptcha()">
                            <i class="fa fa-refresh"></i>
                            Lấy mã khác
                        </a>
                    </div>
                </div>
                <p class="fieldset">
                    <i class="fa fa-lock"></i>
                    <input style="width:200px" class="full-width has-padding has-border" name="capcha"
                           id="signup-password" type="text" placeholder="Mã bảo mật">
                    

                </p>

                <p class="fieldset">
                    <input type="checkbox" id="accept-terms" class="confirm_register">
                    <label for="accept-terms">Tôi đồng ý với các <a href="#">Điều khoản</a> trên website</label>
                </p>

                <p class="fieldset">
                    <input class="btn-edit" onclick="register()" type="submit" value="Đăng ký">
                    <input class="btn-edit" type="reset" onclick="resetText_register()" value="Làm lại">
                </p>
            </form>
        </div>
        <!-- cd-signup -->

        <div id="cd-reset-password"> <!-- reset password form -->
            <p class="cd-form-message">Nếu bạn quên mật khẩu, chỉ cần gõ địa chỉ email của bạn chúng tôi sẽ gửi link để
                khôi phục lại mật khẩu.</p>

            <form class="cd-form" id="cd_form_fotgotpass">
                <p class="msg_fotgotpass" style="color: red;font-weight: bold;text-align: center;"></p>
                <p class="fieldset">
                    <i class="fa fa-envelope"></i>
                    <input class="full-width has-padding has-border" id="reset-email" name="email"
                           placeholder="Email">
                    
                </p>

                <p class="fieldset">
                    <input class="full-width has-padding" type="submit" onclick="forgotPassword()" value="Khôi phục mật khẩu">
                </p>
            </form>

            <p class="cd-form-bottom-message"><a href="javascript:void(0)">Quay trở lại đăng nhập</a></p>
        </div>
        <!-- cd-reset-password -->


        <a href="javascript:void(0)" class="cd-close-form">Close</a>
    </div>
    <!-- cd-user-modal-container -->
</div>
<!-- cd-user-modal -->


<!-- form-bảng-điều-khiển -->
<div class="modal fade cd-postmusic-modal" id="controlpanel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Bảng điều khiển</h4>
            </div>
            <div class="modal-body">
                <div class="col-dk">
                    <ul class="menuSub">
                        <li><a href="/user.html"><i class="fa fa-home"></i> Trang cá nhân</a></li>
                        <li><a href="/dang-nhac.html"><i class="fa fa-upload"></i> Đăng nhạc</a></li>
                        <li><a href="/playlist-cua-toi.html"><i class="fa fa-music"></i> Playlist của bạn</a></li>
                        <li><a href="/bai-hat-da-dang-cua-toi.html"><i class="fa fa-music"></i> Bài hát đã đăng của bạn</a>
                        </li>
                        <li><a href="/doi-mat-khau.html"><i class="fa fa-key"></i> Đổi mật khẩu</a></li>
                        <li><a href="/logout.html"><i class="fa fa-sign-out"></i> Thoát</a></li>
                    </ul>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- form-đăng-nhạc -->
<div class="modal fade" id="postmusic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Đăng nhạc</h4>
            </div>
            <div class="modal-body" id="cd-postmusic">
                <form class="cd-form cd-postmusic" id="form_postmusic" method="post">
                    <input type="hidden" class="capcha-upload-random" name="capcha-random" value="">
                    <p class="msg_postmusic" style="color: red;font-weight: bold;text-align: center;"></p>
                    <p class="fieldset">
                        <i class="fa fa-music"></i>
                        <input class="full-width has-padding has-border" onkeyup="checkName_Media(this)" name="name" id="signup-username" type="text"
                               placeholder="Tên bài hát">
                        <span class="cd-error-message">Error message here!</span>
                    </p>

                    <p class="fieldset">
                        <i class="fa fa-microphone" style="margin-top:-5px "></i>
                        <select class="full-width has-padding has-border" name="artist[]" multiple="" id="upload_form_dj_input">
                        </select>
                        <span class="cd-error-message">Error message here!</span>
                    </p>


                    <p class="fieldset">
                        <i class="fa fa-link"></i>
                        <input class="full-width has-padding has-border" name="mediaurl" id="mediaurl" type="text"
                               placeholder="Link nhạc">

                        <span class="cd-error-message">Error message here!</span>
                    </p>

                    

                    <p class="fieldselect">
                        <i class="fa fa-chevron-down"></i>
                        <select class="full-width has-padding has-border" name="type" id="type_postmusic" onchange="checkType_formUpload()">
                            <option value="">Chọn đúng thể loại nhạc bạn đăng</option>
                            <option value="audio">Bài hát</option>
                            <option value="video">Video</option>
                        </select>
                    </p>
                    <p class="fieldselect">
                        <i class="fa fa-chevron-down"></i>
                        <select class="full-width has-padding has-border" name="category" id="category_postmusic" onchange="checkType_formUpload()">
                            <option value="">Chọn đúng chuyên mục nhạc bạn đăng</option>
                            <?php foreach ($listcategory_form_uploadmusic as $item) { ?>
                                <option class="category_type_<?php echo $item['type']; ?>" value="<?php echo $item['_id']; ?>"><?php echo $item['name']; ?></option>
                            <?php } ?>
                        </select>
                    </p>

                    <p class="fieldselect">
                        <i class="fa fa-chevron-down"></i>
                        <select name="linkType" class="full-width has-padding has-border" id="linkSupport" onchange="check_link_upload(this)">
                            <option value="">Hãy chọn dạng link bạn đã đăng</option>
                            <optgroup label="Hỗ trợ 5 dạng link dưới">
                                <option value="zippyshare">Zippyshare</option>
                                <option value="youtube">Youtube</option>
                                <option value="tunescoop">Tunescoop</option>
                                <option value="soundcloud">Soundcloud</option>
                                <option value="other">Link khác</option>
                            </optgroup>
                        </select>
                    </p>
                    <div class="wrap_capcha">
                        <div id="capcha" class="capcha_upload"><i style="color: white;"></i>
                        </div>
                        <div id="refresh_capcha">
                            <a href="javascript:void(0)" onclick="randomCaptcha()">
                                <i class="fa fa-refresh"></i>
                                Lấy mã khác
                            </a>
                        </div>
                    </div>
                    <p class="fieldset">
                        <i class="fa fa-lock"></i>
                        <input style="width:200px" class="full-width has-padding has-border" name="capcha"
                               id="signup-password" type="text" placeholder="Mã bảo mật">
                    </p>

                    <p class="fieldset">
                        <i class="fa fa-file-text"></i>
                        <textarea class="full-width has-padding has-border" name="content"
                                  placeholder="Thông tin bài hát"></textarea>
                        <span class="cd-error-message">Error message here!</span>
                    </p>


                    <p class="fieldset">
                        <input class="full-width has-padding" onclick="postmusic()" type="submit" value="Đăng nhạc">
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- form-yêu-cầu-nhạc -->
<div class="modal fade" id="require_music" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Yêu cầu nhạc</h4>
            </div>
            <div class="modal-body" id="cd-requiremusic">
                <form class="cd-form cd-requiremusic" id="form_requiremusic" method="post">
                    <input type="hidden" class="capcha-upload-random" name="capcha-random" value="">
                    <p class="msg_requiremusic" style="color: red;font-weight: bold;text-align: center;"></p>
                    <p class="fieldset">
                        <i class="fa fa-music"></i>
                        <input class="full-width has-padding has-border" onkeyup="checkName_RequireMusic(this)" name="name" id="require-username" type="text"
                               placeholder="Tên bài hát">
                        <span class="cd-error-message">Error message here!</span>
                    </p>

                    <p class="fieldset">
                        <i class="fa fa-microphone" style="margin-top:-5px "></i>
                        <select class="full-width has-padding has-border" name="artist[]" multiple="" id="require_form_input_artist">
                        </select>
                        <span class="cd-error-message">Error message here!</span>
                    </p>
                    <p class="fieldselect">
                        <i class="fa fa-chevron-down"></i>
                        <select class="full-width has-padding has-border" name="type" id="type_requiremusic" onchange="checkType_formRequire()">
                            <option value="">Chọn đúng thể loại nhạc bạn đăng</option>
                            <option value="audio">Bài hát</option>
                            <option value="video">Video</option>
                        </select>
                    </p>
                    <p class="fieldselect">
                        <i class="fa fa-chevron-down"></i>
                        <select class="full-width has-padding has-border" name="category" id="category_requiremusic" onchange="checkType_formRequire()">
                            <option value="">Chọn đúng chuyên mục nhạc bạn đăng</option>
                            <?php foreach ($listcategory_form_uploadmusic as $item) { ?>
                                <option class="require_category_type_<?php echo $item['type']; ?>" value="<?php echo $item['_id']; ?>"><?php echo $item['name']; ?></option>
                            <?php } ?>
                        </select>
                    </p>
                    <div class="wrap_capcha">
                        <div id="capcha" class="capcha_upload"><i style="color: white;"></i>
                        </div>
                        <div id="refresh_capcha">
                            <a href="javascript:void(0)" onclick="randomCaptcha()">
                                <i class="fa fa-refresh"></i>
                                Lấy mã khác
                            </a>
                        </div>
                    </div>
                    <p class="fieldset">
                        <i class="fa fa-lock"></i>
                        <input style="width:200px" class="full-width has-padding has-border" name="capcha"
                               id="signup-password" type="text" placeholder="Mã bảo mật">
                    </p>

                    <p class="fieldset">
                        <i class="fa fa-file-text"></i>
                        <textarea class="full-width has-padding has-border" name="content"
                                  placeholder="Thông tin bài hát"></textarea>
                        <span class="cd-error-message">Error message here!</span>
                    </p>


                    <p class="fieldset">
                        <input class="full-width has-padding" onclick="require_music()" type="submit" value="Gửi yêu cầu">
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="/web/js/md5.min.js"></script>

<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>
<script type="text/javascript">

    //Upload File
    /*$('#file_upload').uploadify({
     'swf': '/web/plugin/uploadify/uploadify.swf',
     'uploader': '/web/plugin/uploadify/uploadify.php',
     'fileTypeExts': '*.mp3;*.mp4;',
     'onUploadSuccess': function (file, data, response) {
     var obj = JSON.parse(data);
     if (obj.status == 200) {
     $('#mediaurl').val(obj.file.path);
     } else {
     alert(obj.mss);
     }
     }
     });*/

    $(function() {
        var artistUpload = new djSelectionData();
        artistUpload.init({
            selectElem: "#upload_form_dj_input",
            urlAjax: "/incoming/getlistartist",
            placeholder: "DJ thể hiện (Ví dụ: DJ Hoàng Anh, DJ Bo...)"
        });

        var artistRequire = new djSelectionData();
        artistRequire.init({
            selectElem: "#require_form_input_artist",
            urlAjax: "/incoming/getlistartist",
            placeholder: "DJ thể hiện (Ví dụ: DJ Hoàng Anh, DJ Bo...)"
        });
    });

    /*var newwindow;
     var intId;
     function loginfb(url){
     var  screenX    = typeof window.screenX != 'undefined' ? window.screenX : window.screenLeft,
     screenY    = typeof window.screenY != 'undefined' ? window.screenY : window.screenTop,
     outerWidth = typeof window.outerWidth != 'undefined' ? window.outerWidth : document.body.clientWidth,
     outerHeight = typeof window.outerHeight != 'undefined' ? window.outerHeight : (document.body.clientHeight - 22),
     width    = 500,
     height   = 270,
     left     = parseInt(screenX + ((outerWidth - width) / 2), 10),
     top      = parseInt(screenY + ((outerHeight - height) / 2.5), 10),
     features = (
     'width=' + width +
     ',height=' + height +
     ',left=' + left +
     ',top=' + top
     );

     newwindow=window.open(''+url+'','Login_by_facebook',features);
     if (window.focus) {newwindow.focus()}
     return false;
     }*/
</script>

</html>