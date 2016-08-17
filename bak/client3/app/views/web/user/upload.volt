{% include 'user/header.volt' %}

<div id="content">


    <div class="artists">
        <div class="container">
            <div class="row">

                <div class="col-ldh-9 col-sm-8">
                    <!-- form-đăng-nhạc -->
                    <div tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Đăng nhạc</h4>
                                </div>
                                <div class="modal-body">
                                    {% if msg['status']==0 %}
                                        <div style="color: red;text-align: center;font-weight: bold;">{{ msg['msg'] }}</div>
                                    {% else %}
                                        <div style="color: green;text-align: center;font-weight: bold;">{{ msg['msg'] }}</div>
                                    {% endif %}
                                    <form class="cd-form" method="post">
                                        <p class="fieldset">
                                            <i class="fa fa-music"></i>
                                            <input class="full-width has-padding has-border" name="name"
                                                   id="signup-username" type="text" placeholder="Tên bài hát">
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <i class="fa fa-microphone"></i>
                                            <input class="full-width has-padding has-border" name="namedj"
                                                   id="signup-email" type="text" placeholder="Dj thể hiện"
                                                   onkeyup="getArtist(this);">
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <div class="suggestion" style="display: none;">
                                            <div onclick="$(this).parent().hide()" class="closebtn"><i
                                                        class="md md-close"></i></div>
                                            <ul id="sugges_data">
                                            </ul>
                                        </div>
                                        <ul class="media-func" id="listArtist">
                                        </ul>


                                        <p class="fieldset">
                                            <i class="fa fa-link"></i>
                                            <input class="full-width has-padding has-border" name="mediaurl"
                                                   id="mediaurl" type="text" placeholder="Link nhạc">

                                            <span class="cd-error-message">Error message here!</span>
                                        </p>

                                        <p class="fieldset">
                                            <input type="file" name="file_upload" id="file_upload"/>

                                        <p>

                                        <p class="fieldselect">
                                            <i class="fa fa-chevron-down"></i>
                                            <select class="full-width has-padding has-border" name="type" id="">
                                                <option value="">Chọn đúng thể loại nhạc bạn đăng</option>
                                                <option value="video">Video</option>
                                                <option value="audio">Bài hát</option>
                                            </select>
                                        </p>
                                        <p class="fieldselect">
                                            <i class="fa fa-chevron-down"></i>
                                            <select class="full-width has-padding has-border" name="category" id="">
                                                <option value="">Chọn đúng chuyên mục nhạc bạn đăng</option>
                                                {% for item in listcategory %}
                                                    <option value="{{ item['_id'] }}">{{ item['name'] }}</option>
                                                {% endfor %}
                                            </select>
                                        </p>

                                        <p class="fieldselect">
                                            <i class="fa fa-chevron-down"></i>
                                            <select name="linkType" class="full-width has-padding has-border" id="">
                                                <option value="">Hãy chọn dạng link bạn đã đăng</option>
                                                <optgroup label="Hỗ trợ 4 dạng link dưới">
                                                    <option value="sends">Zippyshare</option>
                                                    <option value="youtube">Youtube</option>
                                                    <option value="ts">Tunescoop</option>
                                                    <option value="soundcloud">Soundcloud</option>
                                                </optgroup>
                                            </select>
                                        </p>

                                        <p class="fieldset">
                                            <i class="fa fa-file-text"></i>
                                            <textarea class="full-width has-padding has-border" name="description"
                                                      placeholder="Thông tin bài hát"></textarea>
                                            <span class="cd-error-message">Error message here!</span>
                                        </p>


                                        <p class="fieldset">
                                            <input class="full-width has-padding" type="submit" value="Đăng nhạc">
                                        </p>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /tabs -->


                </div>

                {% include 'layouts/siderbar_right.volt' %}

            </div>
        </div>
    </div>


</div>

<!--===================footer=====================-->

{% include 'user/footer.volt' %}

<script type="text/javascript" src="/web/js/cbpFWTabs.js"></script>
<script type="text/javascript">


    (function () {

        [].slice.call(document.querySelectorAll('.tabs')).forEach(function (el) {
            new CBPFWTabs(el);
        });

    })();
</script>
