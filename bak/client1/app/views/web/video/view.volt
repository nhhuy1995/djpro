<link href="/web/skins/video-js.css" rel="stylesheet">
<!-- <script src="/web/js/video.js"></script> -->
<script src="http://vjs.zencdn.net/5.8.8/video.js"></script>
<script src="/web/js/videojs-resolution-switcher.js"></script>
<!-- Start js-scroller-->
<script type="text/javascript" src="/web/js/jquery.nanoscroller.js"></script>
<script type="text/javascript">
    $(function () {

        $('.nano').nanoScroller({
            preventPageScrolling: true
        });

    });
</script>
{% include 'layouts/header.volt' %}

<div id="content">
    <div class="bg-cmvideo">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/trang-chu.html"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/video.html">Video</a></li>
                {% for item in listCategory %}
                    <li><a href="{{ item['link'] }}">{{ item['name'] }}</a></li>
                {% endfor %}
            </ul>
        </div>

        <div class="container">
            <div class="row">
                <article class="col-ldh-9 col-sm-8">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="info-video-top">
                                <h2>{{ object.name }}
                                    {% if listartist %}
                                    <span class="bull">-</span>
                                    {% for item in listartist %}
                                    <a href="{{ item['link'] }}"
                                       title="{{ item['username'] }}">{{ item['username'] }}</a>
                                    <span class="bull">{% if !loop.last %}Ft {% endif %}</span>
                                    {% endfor %}
                                    {% endif %}
                                </h2>

                                <div class="info-pd-top">
                                    <p>
                                        <i class="fa fa-youtube-play"></i> Lượt xem: {{ object.view }}
                                        <span class="boutlike" style="color: white;">
                                            <i class="fa fa-thumbs-up"></i> Thích: {{ object.like }}
                                        </span>
                                        <span class="boutdislike" style="color: white;">
                                            <i class="fa fa-thumbs-down"></i> Không thích: {{ object.dislike }}
                                        </span>
                                         <span class="boutdislike" style="color: white;">
                                            <i class="fa fa-user"></i> Người gửi:
                                             {#<a href="{{ object.usercreatelink }}" style="color: #c73030;"
                                                title="{{ object.usercreate }}">
                                                 {{ object.usercreate }}</a> ({{ object.usercreate_namerole }})#}
                                             <a href="{{ object.usercreatelink }}"
                                                style="{% if object.is_role ==1 %} color: #c73030;{% else %} color: #176093;{% endif %}"
                                                title="{{ object.usercreate }}">{{ object.usercreate }}</a>
                                        <span class="role_user">{{ object.usercreate_namerole }}</span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                    {% if checklink %}
                        <video id="videodj" poster="{{ object.priavatar }}" class="video-js vjs-default-skin"
                               width="100%" height="472" loop
                               controls preload="auto" autoplay
                               data-setup='{"techOrder": ["youtube"],"src": "{{ object.mediaurl }}" }'>
                            <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to
                                a
                                web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports
                                    HTML5 video</a></p>
                        </video>
                    {% else %}
                        <video id="videodj" poster="{{ object.priavatar }}"
                               class="video-js vjs-default-skin vjs-resolution-button-label vjs-resolution-button"
                               height="472" loop
                               controls preload="auto" autoplay
                               data-setup='{}'
                        >
                            {% if object.link_video_360 %}
                                {% set media_url = object.link_video_360 %}
                            {% else %}
                                {% set media_url = object.direct_media_url %}
                            {% endif %}
                            <source src="{{ media_url }}" type='video/mp4' label="Default"/>
                            {% if object.link_video_1080 %}
                                <source src="{{ object.link_video_1080 }}" type='video/mp4' label='1080p'/>
                            {% endif %}
                            {% if object.link_video_720 %}
                                <source src="{{ object.link_video_720 }}" type='video/mp4' label='720p'/>
                            {% endif %}
                            {% if object.link_video_480 %}
                                <source src="{{ object.link_video_480 }}" type='video/mp4' label='480p'/>
                            {% endif %}
                            {% if object.link_video_360 %}
                                <source src="{{ object.link_video_360 }}" type='video/mp4' label='360p'/>
                            {% endif %}

                            {% if object.link_video_240 %}
                                <source src="{{ object.link_video_240 }}" type='video/mp4' label='240p'/>
                            {% endif %}

                            {% if object.link_video_144 %}
                                <source src="{{ object.link_video_144 }}" type='video/mp4' label='144p'/>
                            {% endif %}

                            <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to
                                a
                                web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports
                                    HTML5 video</a></p>
                        </video>
                        <script>
                            /*videojs('videodj', {
                             plugins: {
                             resolutions: true
                             }
                             });*/
                            videojs('videodj').videoJsResolutionSwitcher();
                        </script>
                    {% endif %}
                    <!--End-video-->
                    <div class="row col-md-12">
                        <input type="hidden" id="type" value="{{ object.type }}"/>
                        <input type="hidden" id="url_article" value="{{ currentLink }}"/>

                        {% if session['_id'] %}
                            <ul class="media-func">
                                <li><i class="fa fa-plus"></i> <a href="javascript:void(0)"
                                                                  onclick="showFormAddPlaylist();">Thêm vào</a>
                                </li>
                                </li>
                                <li>
                                    <i class="fa fa-thumbs-up"
                                       id="icon-like" {% if check_like._id %} style="color: blue;" {% endif %}></i>
                                    <a href="javascript:void(0)" onclick="likeArticle(this);"
                                       data-id="{{ object._id }}"
                                       checklike="{{ check_like._id>0 ? 1:0 }}">Thích</a>
                                </li>
                                <li>
                                    <i class="fa fa-thumbs-down"
                                       id="icon-dislike" {% if check_dislike._id %} style="color: blue;" {% endif %}></i>
                                    <a href="javascript:void(0)" onclick="dislikeArticle(this);"
                                       data-id="{{ object._id }}" checklike="{{ check_dislike._id>0 ? 1:0 }}">Không
                                        thích</a>
                                </li>
                                <li><i class="fa fa-star"
                                       id="icon-nominations" {% if check_nominations._id %} style="color: blue;" {% endif %}></i>
                                    <a href="javascript:void(0)" onclick="Nominations({{ object._id }});">Đề cử</a>
                                </li>
                                <li>
                                    <i class="fa fa-flag"></i> <a data-target="#sendfeedback" data-toggle="modal"
                                                                  href="javascript:void(0)">Báo lỗi</a>
                                </li>
                                {#<div class="fb-share-button" data-href="{{ currentLink }}"
                                     data-layout="button_count"></div>#}
                                <li><i class="fa fa-share-alt"></i> <a href="javascript:void(0)"
                                                                       onclick="share_facebook()">Chia sẻ</a></li>
                            </ul>
                        {% else %}
                            <ul class="media-func ">
                                <li class="main-nav"><i class="fa fa-plus"></i> <a class="cd-signin"
                                                                                   href="javascript:void(0)">Thêm vào
                                        </a></li>
                                <li class="main-nav"><i class="fa fa-thumbs-up"></i> <a class="cd-signin"
                                                                                        href="javascript:void(0)">Thích</a>
                                </li>
                                <li class="main-nav"><i class="fa fa-thumbs-down"></i> <a class="cd-signin"
                                                                                          href="javascript:void(0)">Không
                                        thích</a></li>
                                <li class="main-nav"><i class="fa fa-star" id="icon-nominations"></i>
                                    <a class="cd-signin" href="javascript:void(0)">Đề cử</a>
                                </li>
                                <li class="main-nav"><i class="fa fa-flag"></i> <a class="cd-signin"
                                                                                   href="javascript:void(0)">Báo
                                        lỗi</a></li>
                                {#<div class="fb-share-button" data-href="{{ currentLink }}"
                                     data-layout="button_count"></div>#}
                                <li><i class="fa fa-share-alt"></i> <a href="javascript:void(0)"
                                                                       onclick="share_facebook()">Chia sẻ</a></li>
                            </ul>
                        {% endif %}
                    </div>
                    {% if listtags %}
                        <div class="tags" style="color: white;"><strong><i class="fa fa-tags"></i> Tags:</strong>
                            {% for item in listtags %}
                                <a href="{{ item['link'] }}">{{ item['name'] }}</a>
                            {% endfor %}
                        </div>
                    {% endif %}
                    <div style="min-height: 331px;" class="lyric">
                        <div class="pd_name_lyric">
                            <h2 class="name_lyric"><b>Lời bài hát: {{ object.name }}</b></h2>

                            <p class="name_post">Lời đăng bởi: <a title="{{ object.usercreate }}"
                                                                  style="{% if object.is_role ==1 %} color: #c73030;{% else %} color: #176093;{% endif %}"
                                                                  href="{{ object.usercreatelink }}"
                                                                  rel="nofollow">{{ object.usercreate }}</a></p>
                        </div>
                        {% if object.content == '' %}
                            <p>No Tracklist!</p>
                        {% endif %}
                        <div class="ads_300_250">
                            <div style="width: 300px; height: 250px; margin: 0px 10px 10px 0px; display: block;"
                                 class="adv_home_300_250" id="S_Lyrics">
                                <div style="width: 300px; height: 250px; overflow: hidden;" id="zS_Lyrics">
                                    <div id="bS_Lyrics1592"><a rel="nofollow" target="_blank"
                                                               href="javascript:void(0)">
                                            <img width="300" height="250" src="/web/images/ad1.png"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="max-height: 255px;overflow: hidden;height: auto" class="pd_lyric trans"
                             id="divLyric">
                            {{ object.content }}
                        </div>
                        <div id="divMoreAddLyric" class="more_add">
                            <a class="btn_view_more" onclick="seeMoreLyric(this)" title="Xem toàn bộ"
                               id="seeMoreLyric" href="javascript:void(0)"><i class="fa fa-angle-down"></i> Xem toàn
                                bộ</a>
                            <a class="btn_view_more" onclick="hideMoreLyric(this)" title="Thu gọn"
                               id="hideMoreLyric" href="javascript:void(0)"><i class="fa fa-angle-up"></i> Thu
                                gọn</a>
                        </div>
                    </div>
                    {% include "/layouts/comment.volt" %}
                    <div class="td_headingw"><h2><a href="/video.html">Video khác</a><i class="fa fa-angle-right"></i>
                        </h2></div>

                    <div class="row slide-cmmusic">
                        <div class="featuredNavigation">
                            <a href="javascript:void(0)" class="prev left recommended-item-control" title="Prev"
                               id="prev"><i
                                        class="fa fa-angle-left"></i></a>
                            <a href="javascript:void(0)" class="next right recommended-item-control" title="Next"
                               id="next"><i
                                        class="fa fa-angle-right"></i></a>
                        </div>
                        <div id="slidemusic" class="our-listing owl-carousel">
                            {% for item in listVideo %}
                                <div class="block-music mr10">
                                    <div class="cover-outer-align">
                                        <a href="{{ item['link'] }}" title="{{ item['name'] }}">
                                            <img class="img-responsive" src="{{ item['priavatar'] }}"
                                                 alt="{{ item['link'] }}"/>
                                        </a>
                                           <span class="icon-circle-play">
                                               <a class="button" href="{{ item['link'] }}" title=""><i
                                                           class="fa fa-play"></i></a>
                                           </span>
                                        <a href="{{ item['link'] }}" title="{{ item['name'] }}">
                                            <div class="video-item-info">
                                            <span class="video-item-view"><span
                                                        class="fa fa-eye"></span> {{ item['view'] }}</span>
                                            <span class="video-item-like"><span
                                                        class="fa fa-clock-o"></span> {{ item['duration'] }}</span>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="details">
                                        <h3><a href="{{ item['link'] }}" class="title tooltip-top"
                                               title="{{ item['name'] }}">{{ item['name'] }}
                                                <span class="paragraph-end"></span></a></h3>

                                        {% include "/layouts/listartist.volt" %}
                                    </div>
                                </div>
                            {% endfor %}
                        </div>
                        <!-- /.our-listing -->

                    </div>

                </article>
                <!-- End-article -->

                <div class="col-ldh-3 col-sm-4">
                    <div class="div2">
                        <div class="adv-300"><img src="http://st.img.polyad.net/2015/12/01/E-Payment_300x120_191115.gif"
                                                  border="0" width="300" height="120"></div>
                        <div class="adv-300">
                            <iframe id="ifr" width="300" height="120"
                                    src="http://customers.fptad.com/QC/HN/Customers/HTML5/P/ParkHill/2015/11/2511/300x120/?link=http://go.polyad.net/clk.aspx?lg=-1&amp;t=5&amp;i=0&amp;b=107877&amp;s=46&amp;r=0&amp;c=1000000&amp;p=203&amp;n=0&amp;l=http%3A//parkhill-premium.vinhomes.vn/&amp;uc=24&amp;uv=undefined&amp;ud=1280x800&amp;rd=100&amp;ui=00c4e36aab544a8f-UNKNOW-UNKNOW&amp;otherlink=http://go.polyad.net/clk.aspx?lg=-1&amp;t=5&amp;i=0&amp;b=107877&amp;s=46&amp;r=0&amp;c=1000000&amp;p=203&amp;n=0&amp;uc=24&amp;uv=undefined&amp;ud=1280x800&amp;rd=100&amp;ui=00c4e36aab544a8f-UNKNOW-UNKNOW&amp;l="
                                    marginwidth="0" allowtransparency="true" marginheight="0" hspace="0" vspace="0"
                                    frameborder="0" scrolling="no"></iframe>
                        </div>

                        <div class="adv-300">
                            <iframe id="large_3_home_Iframe" marginwidth="0" allowtransparency="true" marginheight="0"
                                    hspace="0" vspace="0" frameborder="0" scrolling="no" class="ad_frame_protection"
                                    width="300" height="120"
                                    src="http://st.html.polyad.net/ExtendBanner/96436.htm?v=7#http%3A%2F%2Fvnexpress.net%2F&amp;pos=large_3_home&amp;link=http%3A//go.polyad.net/clk.aspx%3Flg%3D-1%26t%3D5%26i%3D0%26b%3D96436%26s%3D46%26r%3D0%26c%3D1000000%26p%3D204%26n%3D0%26l%3Dhttp%253A//attrage.vinastarmotors.com.vn/product/%26uc%3D24%26uv%3Dundefined%26ud%3D1280x800%26rd%3D100%26ui%3D00c4e36aab544a8f-UNKNOW-UNKNOW&amp;otherlink=http%3A//go.polyad.net/clk.aspx%3Flg%3D-1%26t%3D5%26i%3D0%26b%3D96436%26s%3D46%26r%3D0%26c%3D1000000%26p%3D204%26n%3D0%26uc%3D24%26uv%3Dundefined%26ud%3D1280x800%26rd%3D100%26ui%3D00c4e36aab544a8f-UNKNOW-UNKNOW%26l%3D"></iframe>
                        </div>

                    </div>
                    <div class="sidebar">
                        <h2 class="heading">Có thể bạn muốn xem</h2>

                        <ul class="mlisten">
                            {% for item in listvideobyview %}
                            <li><a href="{{ item['link'] }}" title="{{ item['name'] }}" class="thumb-vd pull-left">
                                    <img src="{{ item['priavatar'] }}" class="avatar_video" alt="{{ item['name'] }}">
                                </a>

                                <h3 class="song-name"><a href="{{ item['link'] }}" title="{{ item['name'] }}"
                                                         class="txt-primary">{{ item['name'] }}</a>
                                </h3>

                                <div class="singer-name">
                                    {% for artist in item['artist'] %}
                                    <a href="{{ artist['link'] }}"
                                       title="{{ artist['username'] }}">{{ artist['username'] }}</a>{% if !loop.last %}<span>Ft</span>{% endif %}
                                    {% endfor %}
                                </div>

                            </li>
                            {% endfor %}
                        </ul>

                    </div>
                    <!--End-sidebar-->
                    <div class="adv-300 div2"><img src="/web/images/ad2.png" alt=""/></div>
                </div>

            </div>
        </div>
    </div>

</div>

<!--===================footer=====================-->

{% include 'layouts/footer.volt' %}
<!-- form-feedback -->
<div class="modal fade" id="sendfeedback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Báo lỗi</h4>
            </div>
            <div class="modal-body">
                <div class="cd-form" id="form_feedback">
                    <p class="fieldset">
                        Vui lòng chọn cụ thể các mục bên dưới để thông báo cho chúng tôi biết vấn đề bạn gặp phải đối
                        với bài hát này.
                    </p>

                    <p class="fieldset">
                        <input type="radio" name="feedback" id="feedback" value="Play quá chậm"> Play quá chậm
                    </p>

                    <p class="fieldset">
                        <input type="radio" name="feedback" id="feedback" value="Không play được"> Không play được
                    </p>

                    <p class="fieldset">
                        <input type="radio" name="feedback" id="feedback" value="Chất lượng kém"> Chất lượng kém
                    </p>

                    <p class="fieldset">
                        <input type="radio" name="feedback" id="feedback" value="Không download được"> Không download
                        được
                    </p>

                    <p class="fieldset">
                        <input type="radio" name="feedback" id="feedback" value="Lỗi khác"> Lỗi khác
                    </p>

                    <p class="fieldset">
                        <input class="full-width has-padding" type="submit" value="Gửi" data-id="{{ object._id }}"
                               data-type="{{ object.type }}" onclick="sendfeedback(this)">
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="atid" value="{{ object._id }}">
<!-- form add playlist -->
<div style="display: none;" id="my-playlist-box">
    <div id="playlist-list-title">
        Chọn Playlist muốn thêm
        <a id="closeAddPlaylist" href="javascript:void(0);" onclick="closeAddPlaylist()">(Đóng lại)</a>
    </div>
    <div style="position: relative; overflow: hidden; width: auto; height: auto;" class="slimScrollDiv">
        <div style="overflow: hidden; width: auto; height: auto;" id="playlist-list"></div>
        <div style="background: none repeat scroll 0% 0% rgb(119, 119, 119); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 64px;"
             class="slimScrollBar ui-draggable"></div>
        <div style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: none repeat scroll 0% 0% rgb(68, 68, 68); opacity: 0.2; z-index: 90; right: 1px;"
             class="slimScrollRail"></div>
    </div>
    <div id="add-new-playlist">
        <input type="text" id="add-playlist-name" placeholder="Thêm Playlist mới - gõ tên Playlist vào đây..."
               name="playlist_name">
        <a onclick="addNewPlaylist()" id="add-new-playlist-btn" class="btn btn-success"
           href="javascript:void(0);">Thêm</a>
    </div>
    <div id="my-playlist-list"><a title="Xem danh sách Playlist của bạn" href="/playlist-cua-toi.html">XEM DANH SÁCH
            PLAYLIST CỦA BẠN</a></div>
</div>
<script type="text/javascript" src="/web/js/myfunction.js"></script>
<script>
    var p = 1;
    $(document).ready(function () {
        {% if object.link_video_360 %}
        //set selected quality default is 360p
        $('li.vjs-menu-item').attr('class', 'vjs-menu-item');
        $('li.vjs-menu-item:contains("360p")').attr('class', 'vjs-menu-item vjs-selected');
        {% endif %}
        var heightlyric = $('#divLyric').height();
        if (heightlyric < 255)   $('#seeMoreLyric').hide();
        $('#hideMoreLyric').hide();
        loadComment();
    });
    function showFormAddPlaylist() {
        $('#my-playlist-box').show();
        $('.wrap-playlist').remove();
        $.get("/incoming/getallplaylist", {}, function (re) {
            var data = re.data;
            var html = '';
            if (data != null) {
                jQuery.each(data, function (index, value) {
                    html +=
                            '<div style="overflow: hidden; width: auto; height: auto;" id="playlist-list" class="wrap-playlist">' +
                            '<div class="playlist-list-item">' +
                            '<div class="playlist-list-name">' +
                            '<a title="Thử Playlist mới" onclick="addSoongToPlaylist(' + value._id + ')" href="javascript:void(0);">' +
                            '<i class="icon-music"></i>' + value.name + '</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                });
                $('.slimScrollDiv').append(html);
            }
        });

    }
    function closeAddPlaylist() {
        $('#my-playlist-box').css('display', 'none');
    }
    function addNewPlaylist() {
        var name = $('#add-playlist-name').val();
        $.get("/incoming/addplaylist", {name: name, type: "video"}, function (re) {
            var result = re.data;
            var html = '';
            if (re.status == 200) {
                html +=
                        '<div style="overflow: hidden; width: auto; height: auto;" id="playlist-list">' +
                        '<div class="playlist-list-item">' +
                        '<div class="playlist-list-name">' +
                        '<a title="Thêm vào" onclick="addSoongToPlaylist(+results._id+)" href="javascript:void(0);">' +
                        '<i class="icon-music"></i>' + result.name + '</a>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                $('.slimScrollDiv').append(html);
                alert('Thêm mới Playlist thành công!');
            }
            else {
                alert(re.mss);
            }
        });
    }
    function addSoongToPlaylist(plid) {
        var atid = $('#atid').val();
        $.get("/incoming/addsoongtoplaylist", {pllid: plid, atid: atid}, function (re) {
            if (re.status == 200) {
                alert('Thêm nhạc vào playlist thành công!');
            }
            else {
                alert(re.mss);
            }
        });
    }


    function loadComment() {
        //check button viewmore comment
        var totalpage = {{ total_page_comment }};
        var atid = {{ object._id }};
        $.get("/incoming/loadcomment", {atid: atid, p: p}, function (re) {
            var data = re.data;
            var html = '';
            if (data != null) {
                htmlComment(data, p, atid);
                p++;
            }
        });
        if (p >= totalpage) $('.viewmore').hide();

    }
</script>
