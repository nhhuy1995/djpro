<link rel="stylesheet" href="/web/skins/jplayer.css"/>
<link rel="stylesheet" href="/web/css/customer.css"/>
<script type="text/javascript" src="/web/js/jquery.jplayer.tth.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var os = (function () {
            var ua = navigator.userAgent.toLowerCase();
            return {
                isWin2K: /windows nt 5.0/.test(ua),
                isXP: /windows nt 5.1/.test(ua),
                isVista: /windows nt 6.0/.test(ua),
                isWin7: /windows nt 6.1/.test(ua),
                isWin8: /windows nt 6.2/.test(ua),
                isWin81: /windows nt 6.3/.test(ua)
            };
        }());

        /*if(os.isXP) {
         var playerSolution = "flash, html";
         }
         else*/
        var playerSolution = "html, flash";

        var repeat = Cookies.get('jPlayer-audio-repeat');
        if (repeat == 'true' || repeat == undefined)
            repeat = true;
        else {
            repeat = false;
        }
        console.log(repeat);
        $("#jquery_jplayer").jPlayer({
            ready: function () {
                $(this).jPlayer("setMedia", {
                    title: "{{ object.name }}",
                    mp3: "{{ object.media_url }}",

                }).jPlayer("play"); // Attempt to auto play the media
            },

            cssSelectorAncestor: "#jp_container",
            swfPath: "/web/playlist/jplayer/jquery.jplayer.swf",
            supplied: "mp3,oga,m4a",
            useStateClassSkin: true,
            autoBlur: false,
            loop: repeat,
            smoothPlayBar: true,
            keyEnabled: true,
            toggleDuration: true,
            wmode: "window",
            solution: playerSolution,
        });

        jQuery(".wolf-jp-popup").click(function () {
            Player = $(this).parent().prev();
            Player.jPlayer("stop");
            var url = jQuery(this).attr("href");
            var popupHeight = jQuery(this).parents(".wolf-jplayer-playlist-container").height();
            var popup = window.open(url, "null", "height=" + popupHeight + ",width=570, top=150, left=150");
            if (window.focus) {
                popup.focus();
            }
            return false;
        });
        jPlayerSetDefault();
    });
</script>
{% include '/layouts/header.volt' %}

<div id="content">
    <input type="hidden" class="articleId" value="{{ object._id }}"/>

    <div class="bgclr"></div>
    <div class="bg-cmmusic">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/bai-hat.html">Bài hát</a></li>
                {% if listcategory %}
                    {% for item in listcategory %}
                        <li><a href="{{ item['link'] }}" title="{{ item['name'] }}"
                               alt="{{ item['name'] }}">{{ item['name'] }}</a></li>
                    {% endfor %}
                {% else %}
                    <li>Đang cập nhật!</li>
                {% endif %}
            </ul>
        </div>

        <div class="container">
            <div class="row">

                <article class="col-ldh-9 col-sm-8">
                    <div class="row">
                        <div class="col-md-5 col-sm-12">
                            <div class="play-list" style="width: 320px;">
                                <div class="album" style="width: 100%;">
                                    <div class="record rotate"></div>
                                    <img class="cover" src="{{ object.priavatar }}" title="{{ object.name }}"
                                         alt="{{ object.name }}">

                                    <div class="glass"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12">
                            <div class="info-song-top">
                                <h2>{{ object.name }}
                                    {% if listartist %}
                                    <span class="bull">-</span>
                                    {% for item in listartist %}
                                    <a href="{{ item['link'] }}"
                                       title="{{ item['username'] }}">{{ item['username'] }}</a>
                                    <span class="bull">{% if !loop.last %}ft. {% endif %}</span>

                                    {% endfor %}
                                    {% endif %}
                                </h2>

                                <div class="info-pd-top">
                                    <span>Phát hành: </span>

                                    <div itemprop="copyrightYear"
                                         class="inline">{{ date('d-m-Y',object.datecreate) }}</div>
                                    <span class="bull">•</span> <span>Thể loại: </span>

                                    <div class="inline">
                                        {% if listcategory %}
                                        {% for item in listcategory %}
                                        <h3>
                                            <a href="{{ item['link'] }}"
                                               title="{{ item['name'] }}">{{ item['name'] }}</a>{% if !loop.last %},{% endif %}
                                        </h3>
                                        {% endfor %}
                                    {% else %}
                                        <h3>
                                            Đang cập nhật!
                                        </h3>
                                        {% endif %}

                                    </div>
                                    <p></p>

                                    <p><i class="fa fa-headphones"></i> Lượt nghe: {{ object.view }}</p>

                                    <p class="boutdownload"><i class="fa fa-download"></i> Lượt
                                        tải: {{ object.download }}</p>
                                    {% if session['_id'] %}
                                    <p class="boutlike"><i class="fa fa-thumbs-up"></i> Thích:
                                        <a href="javascript:void(0)" id="total_likeordislike" onclick="listUserLikeAndDislike(this)" data-type="like" data-articletype="{{ object.type }}" data-id="{{ object._id }}">{{ object.like }}</a>
                                    </p>

                                    <p class="boutdislike"><i class="fa fa-thumbs-down"></i> Không
                                        thích: <a href="javascript:void(0)" id="total_likeordislike" onclick="listUserLikeAndDislike(this)" data-type="dislike" data-articletype="{{ object.type }}" data-id="{{ object._id }}">{{ object.dislike }}</a>
                                    <p>
                                        {% else %}
                                    <p class="boutlike main-nav"><i class="fa fa-thumbs-up"></i> Thích:
                                        <a href="javascript:void(0)" id="total_likeordislike" class="cd-signin">{{ object.like }} </a>
                                    </p>

                                    <p class="boutdislike main-nav"><i class="fa fa-thumbs-down"></i> Không
                                        thích: <a href="javascript:void(0)" id="total_likeordislike" class="cd-signin">{{ object.dislike }} </a>
                                    <p>
                                        {% endif %} 
                                    <p class="user"><i class="fa fa-user"></i> Người gửi:
                                        <a href="{{ object.usercreatelink }}"
                                           style="{% if object.is_role ==1 %} color: #c73030;{% else %} color: #176093;{% endif %}"
                                           title="{{ object.usercreate }}">{{ object.usercreate }}</a>
                                        <span class="role_user">{{ object.usercreate_namerole }}</span>
                                    </p>

                                    <p>
                                    <div class="fb-like" data-href="{{ currentLink }}" data-layout="button_count"
                                         data-action="like" data-show-faces="true" data-share="false"></div>
                                    </p>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- playlist code Html mới -->
                    <div class="wolf-jplayer-playlist-container">
                        <div class="wolf-jplayer-playlist">

                            <div id="jplayer_container" class="jplayer_container">
                                <div id="jquery_jplayer" class="jp-jplayer">

                                </div>
                                <div id="jp_container" class="jp-audio">
                                    <!--<div class="ab-rotate rotate"></div>
                                    <div class="gl"></div>-->
                                    {#<a href="{{ object.link }}" class="wolf-jp-popup" title="Nghe cửa sổ mới"></a>#}
                                    <div class="jp-type-playlist">
                                        <div class="jp-gui jp-interface">
                                            <ul class="jp-controls">
                                                <!--<li><a href="javascript:;" class="jp-previous" tabindex="1"></a></li>-->
                                                <li><a href="javascript:;" class="jp-play" tabindex="1"></a></li>
                                                <li><a href="javascript:;" class="jp-pause" tabindex="1"
                                                       style="display: none;"></a></li>
                                                <!--<li><a href="javascript:;" class="jp-next" tabindex="1"></a></li>-->
                                                <li class="wolf-volume">
                                                    <a href="javascript:;" class="jp-mute" tabindex="1"
                                                       title="mute"></a>
                                                    <a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"
                                                       style="display: none;"></a>
                                                </li>
                                                <li><a href="javascript:;" class="jp-volume-max wolf-volume"
                                                       tabindex="1" title="max volume"></a></li>
                                            </ul>
                                            <div class="jp-progress">
                                                <div class="jp-seek-bar" style="width: 100%;">
                                                    <div class="jp-play-bar" style="width: 0%;"></div>
                                                </div>
                                            </div>
                                            <div class="jp-volume-bar wolf-volume" style="display: block;">
                                                <div class="jp-volume-bar-value" style="width: 80%;"></div>
                                            </div>
                                            <div class="jp-current-time">00:00</div>
                                            <div class="jp-duration">01:25</div>

                                            <ul class="jp-toggles">
                                                {#<li><a href="javascript:;" class="jp-shuffle" tabindex="1"
                                                       title="shuffle"></a></li>#}
                                                {#<li><a href="javascript:;" class="jp-shuffle-off" tabindex="1"
                                                       title="shuffle off" style="display: none;"></a></li>#}
                                                <li class="drop">
                                                    <a class="jp-click" href="javascript:void(0)"></a>
                                                    <div class="dropdownContain">
                                                        <div class="dropOut">
                                                            <div class="triangle"></div>
                                                            <ul>
                                                                {% if object.media_link_320k %}
                                                                    <li><a class="media_quality_select"
                                                                           href="javascript:;"
                                                                           data-media-src="{{ object.media_link_320k }}"
                                                                           data-media-type="320">
                                                                            320K
                                                                        </a></li>
                                                                {% endif %}
                                                                {% if object.media_link_128k %}
                                                                    <li><a class="media_quality_select"
                                                                           href="javascript:;"
                                                                           data-media-src="{{ object.media_link_128k }}"
                                                                           data-media-type="128">
                                                                            128K
                                                                        </a></li>
                                                                {% endif %}
                                                                {% if object.media_link_64k %}
                                                                    <li><a class="media_quality_select" style="color: #B302CB"
                                                                           href="javascript:;"
                                                                           data-media-src="{{ object.media_link_64k }}"
                                                                           data-media-type="64">
                                                                            64K
                                                                        </a></li>
                                                                {% endif %}
                                                            </ul>
                                                        </div>
                                                    </div>

                                                </li>
                                                <li><a href="javascript:;" class="jp-repeat" tabindex="1"
                                                       title="repeat"></a></li>
                                                <li><a href="javascript:;" class="jp-repeat-off" tabindex="1"
                                                       title="repeat off" style="display: none;"></a></li>
                                            </ul>


                                        </div>


                                        <div class="jp-no-solution" style="display: none;">
                                            <span>Update Required</span>
                                            To play the media you will need to either update your browser to a recent
                                            version or update your <a href="http://get.adobe.com/flashplayer/"
                                                                      target="_blank">Flash plugin</a>.
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End-->

                    <div class="row col-md-12">
                        <input type="hidden" id="type" value="{{ object.type }}"/>
                        <input type="hidden" id="url_article" value="{{ currentLink }}"/>
                        {% if session['_id'] %}
                            <ul class="media-func">
                                <li><i class="fa fa-plus"></i> <a href="javascript:void(0)"
                                                                  data-toggle="modal" data-target="#my-playlist-box" onclick='showFormAddPlaylist()'>Thêm vào</a>
                                </li>

                                <li><i class="fa fa-download"></i> <a href="javascript:void(0)" data-toggle="modal" data-target="#down-mp3">Tải
                                        về</a>
                                </li>
                                <li><i class="fa fa-thumbs-up"
                                       id="icon-like" {% if check_like._id %} style="color: blue;" {% endif %}></i>
                                    <a href="javascript:void(0)" onclick="likeArticle(this);" data-id="{{ object._id }}"
                                       checklike="{{ check_like._id>0 ? 1:0 }}">Thích</a>
                                </li>
                                <li><i class="fa fa-thumbs-down"
                                       id="icon-dislike" {% if check_dislike._id %} style="color: blue;" {% endif %}></i>
                                    <a href="javascript:void(0)" onclick="dislikeArticle(this);"
                                       data-id="{{ object._id }}"
                                       checklike="{{ check_dislike._id>0 ? 1:0 }}">Không thích</a>
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
                                <li>
                                    <i class="fa fa-share-alt"></i>
                                    <a href="javascript:void(0)"  data-toggle="modal" data-target="#embed-share-popup">Chia sẻ</a>
                                    <!-- <a href="javascript:void(0)" onclick="share_facebook()">Chia sẻ</a> -->
                                </li>
                            </ul>
                        {% else %}
                            <ul class="media-func ">
                                <li class="main-nav"><i class="fa fa-plus"></i> <a class="cd-signin"
                                                                                   href="javascript:void(0)">Thêm vào                            </a></li>
                                <li><i class="fa fa-download"></i> <a href="javascript:void(0)" data-toggle="modal" data-target="#down-mp3">Tải
                                        về</a>
                                <li class="main-nav"><i class="fa fa-thumbs-up"></i> <a class="cd-signin"
                                                                                        href="javascript:void(0)">Thích</a>
                                </li>
                                <li class="main-nav"><i class="fa fa-thumbs-down"></i> <a class="cd-signin"
                                                                                          href="javascript:void(0)">Không
                                        thích</a></li>
                                <li class="main-nav"><i class="fa fa-star"></i> <a class="cd-signin"
                                                                                   href="javascript:void(0)">Đề cử</a>
                                </li>
                                <li class="main-nav"><i class="fa fa-flag"></i> <a class="cd-signin"
                                                                                   href="javascript:void(0)">Báo
                                        lỗi</a></li>
                                {#<div class="fb-share-button" data-href="{{ currentLink }}"
                                     data-layout="button_count"></div>#}
                                <li>
                                    <i class="fa fa-share-alt"></i>
                                    <a href="javascript:void(0)"  data-toggle="modal" data-target="#embed-share-popup">Chia sẻ</a>
                                    <!-- <a href="javascript:void(0)" onclick="share_facebook()">Chia sẻ</a> -->
                                </li>
                            </ul>
                        {% endif %}
                    </div>
                    {% if listtags %}
                        <div class="tags"><strong><i class="fa fa-tags"></i> Tags:</strong>
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

                    <div class="td_heading"><h2><a href="/album.html">Album khác</a><i
                                    class="fa fa-angle-right"></i></h2></div>

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
                            {% for item in listalbum %}
                                <div class="block-music mr10">
                                    <div class="cover-outer-align">
                                        <a href="{{ item['link'] }}">
                                            <img class="img-responsive" src="{{ item['priavatar'] }}"
                                                 alt="{{ item['name'] }}"/>
                                        </a>
                                           <span class="icon-circle-play">
                                               <a class="button" href="{{ item['link'] }}" title=""><i
                                                           class="fa fa-play"></i></a>
                                           </span>
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
                        <h2 class="heading">Nghe Nhiều</h2>

                        <ul class="mlisten">
                            {% for item in listmusicbyview %}
                            <li><a href="{{ item['link'] }}" title="{{ item['name'] }}" class="thumb pull-left">
                                    <img src="{{ item['priavatar'] }}" alt="{{ item['name'] }}">
                                </a>

                                <h3 class="song-name"><a href="{{ item['link'] }}" title="{{ item['name'] }}"
                                                         class="txt-primary">{{ item['name'] }}</a>
                                </h3>

                                <div class="singer-name">
                                    {% for artist in item['artist'] %}
                                    <a href="{{ artist['link'] }}"
                                       title="{{ artist['username'] }}">{{ artist['username'] }}</a>{% if !loop.last %}<span>ft.</span>{% endif %}
                                    {% endfor %}
                                </div>

                            </li>
                            {% endfor %}
                        </ul>

                    </div>
                    <div class="sidebar">
                        <h2 class="heading">Có thể bạn muốn nghe</h2>

                        <div class="main-boder">
                            <div data-special-type="app" class="player-container2">
                                <div data-special-type="app" class="player-container2">
                                    <ul class="listtop">

                                        {% for key,item in listMusic %}
                                            {% set cl = 'special-4' %}
                                            {% if key == 0 %} {% set cl = 'special-1' %} {% endif %}
                                            {% if key == 1 %} {% set cl = 'special-2' %} {% endif %}
                                            {% if key == 2 %} {% set cl = 'special-3' %} {% endif %}
                                            <li><a href="{{ item['link'] }}" title="{{ item['name'] }}"><span
                                                            class="number {{ cl }}">{{ key+1 }}</span>{{ item['name'] }}
                                                </a></li>
                                        {% endfor %}
                                    </ul>
                                    <!--menu-->
                                </div>
                            </div>
                        </div>
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
{% include 'layouts/share_popup.volt' %}

<a href="javascript:void(0)" class="cd-top">Top</a>
<div class="modal fade" id="controlpanel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <!-- form-bảng-điều-khiển -->
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
                        <li><a href="/dang-nhac.html" data-toggle="modal"></i> Đăng nhạc</a></li>
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
<!-- form-user-like -->
<div class="modal fade" id="user-like" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title header_formlike" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">

                <ul class="m-user">
                    <div style="height:300px">
                        <div class="nano">
                            <div class="content" id="block_list_user">

                            </div>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
    </div>
</div><!--End-->

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
<!-- form-down-mp3 -->
<div class="modal fade" id="down-mp3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cloud-download"></i> Download</h4>
            </div>
            <div class="modal-body">
                <div style="height:300px">
                    <div class="nano">
                        <div class="content">
                            <ul class="down-app">
                                <p>Click vào 1 trong các liên kết bên dưới để Download về máy Bài hát: <strong>{{ object.name }}</strong></p>
                                {% if object.media_link_320k %}
                                    <li><a href="javascript:void(0)" title="320k" onclick="downloadMedia(this)" data-id="{{ object._id }}" data-quality="media_link_320k">320k</a></li>
                                {% endif %}
                                {% if object.media_link_128k %}
                                    <li><a href="javascript:void(0)" title="128k" onclick="downloadMedia(this)" data-id="{{ object._id }}" data-quality="media_link_128k">128k</a></li>
                                {% endif %}
                                {% if object.media_link_64k %}
                                    <li><a href="javascript:void(0)" title="64k" onclick="downloadMedia(this)" data-id="{{ object._id }}" data-quality="media_link_64k">64k</a></li>
                                {% endif %}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--End-->

{% include 'layouts/form_add_playlist.volt' %}

<script type="text/javascript" src="/web/js/myfunction.js"></script>
<script>
    var p = 1;
    $(document).ready(function () {
        var heightlyric = $('#divLyric').height();
        if (heightlyric < 255)   $('#seeMoreLyric').hide();
        $('#hideMoreLyric').hide();
        loadComment();

        $(".media_quality_select").click(function () {
            var player = $("#jquery_jplayer");
            var audioRrl = $(this).attr("data-media-src");
            var currentTime = jplayerCurrentTime();
            var quality = $(this).attr("data-media-type");
            //set active icon quanlity
            $('.media_quality_select').removeAttr('style');
            $(this).attr('style', 'color: #B302CB');
            player.jPlayer("setMedia", {
                mp3: audioRrl
            });
            player.jPlayer("play", currentTime);
            Cookies.set('jPlayer-audio-quality', quality, {expires: 7});
        });
    });

    function jplayerCurrentTime() {
        var currentTime = $(".jp-current-time").text();
        var elems = currentTime.split(":");
        return parseInt(elems[0]) * 60 + parseInt(elems[1]);
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
        if (p >= totalpage) $('#viewmore').hide();

    }
</script>
