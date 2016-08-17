<script type="text/javascript" src="/web/js/cbpFWTabs.js"></script>
<div class="td_heading"><h2><a href="#">Bình luận</a><i class="fa fa-angle-right"></i></h2></div>
<div class="tabs tabs-style-tzoid">
    <nav>
        <ul>
            <li class=""><a href="#section-tzoid-1"><span>Thành viên bình luận ({{ total_comment }})</span></a></li>
            <li class=""><a href="#section-tzoid-2"><span>Facebook</span></a></li>
            {#<li class="tab-current"><a href="#section-tzoid-3"><span>Google +</span></a></li>#}
        </ul>
    </nav>
    <div class="content-wrap">
        <input type="hidden" id="session_username" value="{{ session['username'] }}">
        <section class="" id="section-tzoid-1">
            <ul class="row bv-comment">
                <li class="col-md-12">
                                        <textarea id="content_comment"
                                                  onfocus="if (this.value==this.defaultValue) this.value = ''"
                                                  onblur="if (this.value=='') this.value = this.defaultValue"
                                                  placeholder="Nội dung comment"></textarea>
                </li>
                {% if session['_id'] %}
                    <li class="col-md-12"><input type="submit" value="Gửi ngay" onclick="sendComment(this);"
                                                 data-id="{{ object._id }}"
                                                 class="button-cm">
                    </li>
                {% else %}
                    <li class="col-md-12 main-nav"><input type="submit" value="Gửi ngay" class="button-cm cd-login">
                    </li>
                {% endif %}
            </ul>
            <div class="infocomment">
            </div>
            <div class="wrap-viewmore" id="viewmore">
                <div class="viewmore">
                    <a href="javascript:void(0)" onclick="loadComment();">Xem thêm</a>
                </div>
            </div>
        </section>
        <section class="" id="section-tzoid-2">
            <p></p>
            <div class="fb-comments" data-href="http://{{ config.application.site~object.link }}" data-width="100%" data-numposts="5"></div>
            {#<div fb-xfbml-state="rendered" data-numposts="5" data-href="{{ config.application.site~object.link }}" class="fb-comments"><span
                        style="height: 205px; width: 800px;"><iframe
                            style="border: none; overflow: hidden; height: 205px; width: 100%;"
                            src="https://www.facebook.com/plugins/comments.php?api_key=704279352982449&amp;channel_url=http%3A%2F%2Fstatic.ak.facebook.com%2Fconnect%2Fxd_arbiter%2F44OwK74u0Ie.js%3Fversion%3D41%23cb%3Df14cb718%26domain%3Dcongnghe.lamwebseo.vn%26origin%3Dhttp%253A%252F%252Fcongnghe.lamwebseo.vn%252Ffd706d4%26relation%3Dparent.parent&amp;href=http%3A%2F%2Flocalhost%3A1011%2F%252fhtc-one-m9-gold-cty.html&amp;locale=vi_VN&amp;numposts=5&amp;sdk=joey&amp;version=v2.0&amp;width=550"
                            class="fb_ltr" title="Facebook Social Plugin" scrolling="no"
                            name="f2eb851ac4" id="f6b9a2d0"></iframe></span></div>#}
            <p></p>
        </section>
        {#<section class="content-current" id="section-tzoid-3"><p>3</p></section>#}
    </div>
    <!-- /content -->
</div>
<script>
    (function () {

        [].slice.call(document.querySelectorAll('.tabs')).forEach(function (el) {
            new CBPFWTabs(el);
        });

    })();
</script>