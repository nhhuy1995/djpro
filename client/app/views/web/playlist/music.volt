<link rel="stylesheet" href="/web/skins/jplayer.css" type="text/css"/>
<script type="text/javascript" src="/web/playlist/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="/web/js/jplayer.playlist.js"></script>
<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function () {
        var repeat = Cookies.get('jPlayer-audio-repeat');
        if (repeat == 'true' || repeat == undefined)
            repeat = true;
        else {
            repeat = false;
        }

        var playlistPlayer = new jPlayerPlaylist({
            jPlayer: "#jquery_jplayer",
            cssSelectorAncestor: "#jp_container"
        }, [
            {% for key,item in listSong %}
            {
                title: "{{ key+1 }}. {{ item['name'] }}",
                artistname: "{{ item['listartistname'] }}",
                {#artistlink: "{{ item['listartist']['link'] }}",#}
                free: true,
                id: "{{ item['_id'] }}",
                checklike: "{{ item['checklike'] }}",
                nominations: "{{ item['nominations'] }}",
                link: "{{ item['link'] }}",
                type: "{{ item['type'] }}",
                name: "{{ item['name'] }}",
                media_link_128k: "{{ item['media_link_128k'] }}",
                media_link_64k: "{{ item['media_link_64k'] }}",
                media_link_320k: "{{ item['media_link_320k'] }}",
                {#mp3: "{{ item['direct_media_url'] }}"#}
            },
            {% endfor %}
        ], {
            loop: repeat,
            playlistOptions: {
//                enableRemoveControls: true,
                autoPlay: true,
                displayItemAction: function (elem) {
                    return '<span class="wolf-jp-song-url">'
                            {% if session['_id'] %}
                            + '<a class="addplaylist" href="javascript:void(0)" title="Thêm vào" data-toggle="modal" data-target="#my-playlist-box" onclick="showFormAddPlaylist(' + elem.id + ');"></a>'
                            + '<a class="like" ' + (elem.checklike == 1 ? 'id="icon-active"' : '') + ' checklike="' + elem.checklike + '"'
                            + 'href="javascript:void(0)" ' + (elem.checklike == 1 ? 'title="Đã like"' : title = "Like") + ' data-id="' + elem.id + '" onclick="likeSong(this);" ></a>'
                            + '<a class="decu" ' + (elem.nominations == 1 ? 'id="icon-active"' : '') + ' ' + (elem.nominations == 1 ? 'title="Đã đề cử"' : 'title="Đề cử"') + ' href="javascript:void(0)" onclick="Nominations_song(this)" data-id="' + elem.id + '" ></a>'
                            {% else %}
                            + '<a class="addplaylist" href="javascript:void(0)" title="Thêm vào" onclick="showlogin()"></a>'
                            + '<a onclick="showlogin()" class="like" ' + (elem.checklike == 1 ? 'id="icon-active"' : '') + ' checklike="' + elem.checklike + '"'
                            + 'href="javascript:void(0)" ' + (elem.checklike == 1 ? 'title="Đã like"' : title = "Like") + ' data-id="' + elem.id + '" ></a>'
                            + '<a onclick="showlogin()" class="decu" ' + (elem.nominations == 1 ? 'id="icon-active"' : '') + ' ' + (elem.nominations == 1 ? 'title="Đã đề cử"' : 'title="Đề cử"') + ' href="javascript:void(0)" data-id="' + elem.id + '" ></a>'
                            {% endif %}
                            + '<a class="taive" href="javascript:void(0)" data-name="' + elem.name + '" data-id="' + elem.id + '" data-link320="' + elem.media_link_320k + '" data-link128="' + elem.media_link_128k + '" data-link64="' + elem.media_link_64k + '" ' +
                            'onclick="openFormDownloadOfPlaylist(this)" title="Tải về"></a>'
//                            + '<a class="share" href="javascript:void(0)" title="Chia sẻ" target="_blank"></a>'
                            + '<a class="popup" href="' + elem.link + '" title="Nghe cửa sổ mới" target="_blank"></a>'
                            + '</span>';


                },
                playItemCallback: function (item, indexSong) {
                    $.post("/incoming/getlyric", {id: item.id}, function (re) {
                        var data = re.data;
                        if (re.status == 200) {
                            $('.blank_music').attr('href', data.link);
                            if (data.content != '') { //if lyrics not empty
                                //check lyric
                                $('.lyric').show();
                                $('#divLyric').html(data.content);
                                if (data.userinfo.is_role == 1) var color_lyricCreate = '#c73030';
                                else var color_lyricCreate = '#176093';
                                var html = '<h2 class="name_lyric"><b>Lời bài hát: ' + data.name + '</b></h2>' +
                                        '<p class="name_post">Lời đăng bởi: <a rel="nofollow" style="color:' + color_lyricCreate + '" href="' + data.userinfo.link + '" title="' + data.userinfo.username + '">' + data.userinfo.username + '</a></p>';
                                $('.pd_name_lyric').html(html);
                                var heightlyric = $('#divLyric').height();
                                if (heightlyric < 255) $('#seeMoreLyric').hide();
                                else $('#seeMoreLyric').show();
                            } else {
                                $('.lyric').hide();
                            }
                            //generate html quality
                            var htmlQuality = '<div class="dropOut"><div class="triangle"></div>' +
                                    '<ul>';
                            var insertMediaLink = function (media_link, type, label) {
                                return '<li><a onclick="changeQuality(this)" class="media_quality_select"'
                                        + 'href="javascript:void(0)" data-media-src="' + media_link + '"'
                                        + 'data-media-type="' + type + '"> ' + label + ' </a></li>';
                            }

                            if (data.media_link_320k != undefined)
                                htmlQuality += insertMediaLink(data.media_link_320k, '320', '320K');
                            if (data.media_link_128k != undefined)
                                htmlQuality += insertMediaLink(data.media_link_128k, '128', '128K');
                            if (data.media_link_64k != undefined)
                                htmlQuality += insertMediaLink(data.media_link_64k, '64', '64K');

                            htmlQuality += '</ul></div>';
                            $('.dropdownContain').html(htmlQuality);

                            var quality = Cookies.get('jPlayer-audio-quality');
                            if (typeof quality != 'string' || quality != 'undefined') {
                                quality = '128';
                            }
                            changeQuality(".media_quality_select[data-media-type='" + quality + "']", data);
                            var currentUrl = window.location.href;
                            if (indexSong > 0)
                                var newUrl = addParameterToUrl(currentUrl, 'st', indexSong + 1, false);
                            else 
                                var newUrl = removeURLParameter(currentUrl, 'st');
                            window.history.replaceState(null, null, newUrl);
                        } else {
                            alert(re.msg);
                        }
                    });
                },
                nextActionCallback: function (index) {
                }
            },
            cssSelector: {
                videoPlay: ".jp-video-play",
                play: ".jp-play",
                pause: ".jp-pause",
                stop: ".jp-stop",
                seekBar: ".jp-seek-bar",
                playBar: ".jp-play-bar",
                mute: ".jp-mute",
                unmute: ".jp-unmute",
                volumeBar: ".jp-volume-bar",
                volumeBarValue: ".jp-volume-bar-value",
                volumeMax: ".jp-volume-max",
                playbackRateBar: ".jp-playback-rate-bar",
                playbackRateBarValue: ".jp-playback-rate-bar-value",
                currentTime: ".jp-current-time",
                duration: ".jp-duration",
                title: ".jp-title",
                fullScreen: ".jp-full-screen",
                restoreScreen: ".jp-restore-screen",
                repeat: ".jp-repeat",
                repeatOff: ".jp-repeat-off",
                gui: ".jp-gui",
                noSolution: ".jp-no-solution"
            },
            stateClass: {
                playing: "jp-state-playing",
                seeking: "jp-state-seeking",
                muted: "jp-state-muted",
                looped: "jp-state-looped",
                fullScreen: "jp-state-full-screen",
                noVolume: "jp-state-no-volume"
            },
            swfPath: "jplayer",
            supplied: "oga, mp3",
            wmode: "window",
            useStateClassSkin: true,
            autoBlur: false,
            smoothPlayBar: true,
            keyEnabled: true,

        });
        isPlaylistPage = true;
        jPlayerPlaylistSetDefault(playlistPlayer);
        playlistPlayer.play(parseInt({{ st }}) - 1);
    });
    //]]>
</script>
{% include 'layouts/header.volt' %}
<input type="hidden" id="type" value="{{ object.type }}"/>
<div id="content">
    <div class="bgclr"></div>
    <div class="bg-cmmusic">
        <div class="container">
            {% include 'layouts/breadcrumb.volt' %}
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

                                    <div class="inline"
                                         itemprop="copyrightYear">{{ date('d-m-Y',object.datecreate) }}</div>
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

                                    <p class="boutdownload"><i class="fa fa-headphones"></i> Lượt
                                        nghe: {{ object.view }}</p>
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
                                    <p>
                                    <div class="fb-like" data-href="{{ currentLink }}" data-layout="button_count"
                                         data-action="like" data-show-faces="true" data-share="false"></div>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="wolf-jplayer-playlist-container  wolf-jplayer-scrollbar">
                        <div class="wolf-jplayer-playlist">

                            <div id="jplayer_container" class="jplayer_container">
                                <div id="jquery_jplayer" class="jp-jplayer">

                                </div>
                                <div id="jp_container" class="jp-audio">
                                    <!--<div class="ab-rotate rotate"></div>
                                    <div class="gl"></div>-->
                                    <a href="" class="wolf-jp-popup blank_music" title="Nghe cửa sổ mới"></a>

                                    <div class="jp-type-playlist">
                                        <div class="jp-gui jp-interface">
                                            <ul class="jp-controls">
                                                <li><a href="javascript:void(0)" class="jp-previous" tabindex="1"></a>
                                                </li>
                                                <li><a href="javascript:void(0)" class="jp-play" tabindex="1"></a></li>
                                                <li><a href="javascript:void(0)" class="jp-pause" tabindex="1"
                                                       style="display: none;"></a></li>
                                                <li><a href="javascript:void(0)" class="jp-next" tabindex="1"></a></li>
                                                <li class="wolf-volume">
                                                    <a href="javascript:void(0)" class="jp-mute" tabindex="1"
                                                       title="mute"></a>
                                                    <a href="javascript:void(0)" class="jp-unmute" tabindex="1"
                                                       title="unmute"
                                                       style="display: none;"></a>
                                                </li>
                                                <li><a href="javascript:void(0)" class="jp-volume-max wolf-volume"
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
                                                <li><a href="javascript:void(0)" class="jp-shuffle" tabindex="1"
                                                       title="shuffle"></a></li>
                                                <li><a href="javascript:void(0)" class="jp-shuffle-off" tabindex="1"
                                                       title="shuffle off" style="display: none;"></a></li>
                                                <li class="drop">
                                                    <a class="jp-click" href="javascript:void(0)"></a>

                                                    <div class="dropdownContain">

                                                    </div>

                                                </li>
                                                <li><a href="javascript:void(0)" class="jp-repeat" tabindex="1"
                                                       title="repeat"></a></li>
                                                <li><a href="javascript:void(0)" class="jp-repeat-off" tabindex="1"
                                                       title="repeat off" style="display: none;"></a></li>
                                            </ul>


                                        </div>

                                        <div class="jp-playlist">

                                            <div id="main-scrollbar">
                                                <div class="nano">
                                                    <div class="content">
                                                        <ul>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
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
                    <div class="row col-md-12">
                        <input type="hidden" id="url_article" value="{{ currentLink }}"/>
                        {% if session['_id'] %}
                            <ul class="media-func">
                                <li><i class="fa fa-plus"></i>
                                    <a onclick="showFormAddPlaylist()" data-target="#my-playlist-box" data-toggle="modal" href="javascript:void(0)">Thêm vào</a>
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
                                    <a href="javascript:void(0)" onclick="Nominations({{ object._id }});">Đề
                                        cử</a>
                                </li>
                                {#<li><i class="fa fa-share-alt"></i> <a href="javascript:void(0)">Chia sẻ</a></li>#}
                                {% if session['_id'] %}
                                    <li>
                                        <i class="fa fa-flag"></i> <a data-target="#sendfeedback" data-toggle="modal"
                                                                      href="javascript:void(0)">Báo lỗi</a>
                                    </li>
                                {% else %}
                                    <li class="main-nav">
                                        <i class="fa fa-flag"></i> <a class="cd-signin" href="javascript:void(0)">Báo
                                            lỗi</a>
                                    </li>
                                {% endif %}
                                {# <div class="fb-share-button" data-href="{{ currentLink }}"
                                      data-layout="button_count"></div>#}
                                <li><i class="fa fa-share-alt"></i>
                                    <!-- <a href="javascript:void(0)" onclick="share_facebook()">Chia sẻ</a> -->
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#embed-share-popup">Chia sẻ</a>
                                </li>
                            </ul>
                        {% else %}
                            <ul class="media-func ">
                                <li class="main-nav" id="showpopup"><i class="fa fa-plus"></i> <a class="cd-signin"
                                                                                                  href="javascript:void(0)">Thêm
                                        vào
                                    </a></li>
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
                                {# <div class="fb-share-button" data-href="{{ currentLink }}"
                                      data-layout="button_count"></div>#}
                                <li><i class="fa fa-share-alt"></i>
                                    <!-- <a href="javascript:void(0)" onclick="share_facebook()">Chia sẻ</a> -->
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#embed-share-popup">Chia sẻ</a>
                                </li>
                            </ul>
                        {% endif %}
                    </div>
                    {% if listags %}
                        <div class="tags"><strong><i class="fa fa-tags"></i> Tags:</strong>
                            {% for item in listags %}
                                <a href="{{ item['link'] }}">{{ item['name'] }}</a>
                            {% endfor %}
                        </div>
                    {% endif %}
                    {% if listSong %}
                        <div style="min-height: 331px;" class="lyric">
                            <div class="pd_name_lyric">
                            </div>


                            <div class="ads_300_250">
                               {{ ads.MUSIC_PLAY_DESKTOP_LYRIC['current_content'] }}
                            </div>
                            <div style="height:auto;max-height:255px;overflow:hidden;" class="pd_lyric trans"
                                 id="divLyric">
                            </div>

                            <div id="divMoreAddLyric" class="more_add">
                                <a class="btn_view_more" onclick="seeMoreLyric(this)" title="Xem toàn bộ"
                                   id="seeMoreLyric"
                                   href="javascript:void(0)"><i
                                            class="fa fa-angle-down"></i> Xem toàn bộ</a>
                                <a class="btn_view_more" onclick="hideMoreLyric(this)" title="Thu gọn"
                                   id="hideMoreLyric"
                                   href="javascript:void(0)"><i
                                            class="fa fa-angle-up"></i> Thu gọn</a>
                            </div>
                        </div>
                    {% endif %}
                    {% include "/layouts/comment.volt" %}
                    <div class="td_heading">
                        <h2>
                            {% if object.type == 'topic' %}
                                <a href="/chu-de.html">Chủ đề khác</a>
                            {% elseif object.type == 'album' %}
                                <a href="/album.html">Album khác</a>
                            {% elseif object.type == 'playlist' %}
                                <a href="/playlist.html">Playlist khác</a>
                            {% endif %}
                            <i class="fa fa-angle-right"></i>
                        </h2>
                    </div>

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
                                        <a href="{{ item['link'] }}" title="{{ item['name'] }}">
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
                        <div class="adv-300">
                            {{ ads.HOME_DESKTOP_RIGHT_1['current_content'] }}
                        </div>
                        <div class="adv-300">
                            {{ ads.HOME_DESKTOP_RIGHT_2['current_content'] }}
                        </div>

                        <div class="adv-300">
                            {{ ads.HOME_DESKTOP_RIGHT_3['current_content'] }}
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
                                    <a href="{{ artist['link'] }}">{{ artist['username'] }}</a>{% if !loop.last %}<span>ft.</span>{% endif %}
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
                                            <li>
                                                <span class="number {{ cl }}">{{ key+1 }}</span>
                                                <a href="{{ item['link'] }}" title="{{ item['name'] }}">{{ item['name'] }}
                                                </a></li>
                                        {% endfor %}
                                    </ul>
                                    <!--menu-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End-sidebar-->
                    <div class="adv-300 div2">
                        {{ ads.MUSIC_PLAY_DESKTOP_BELOW_SUGGEST['current_content'] }}
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<!--===================footer=====================-->

{% include 'layouts/footer.volt' %}
{% include 'layouts/form_add_playlist.volt' %}
{% include 'layouts/share_popup.volt' %}
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
<input type="hidden" id="atid">
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

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--End-->
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
<!-- form add playlist -->
<div style="display: none;z-index: 999;" id="my-playlist-box">
    <div data-atid="1409135130" id="addPlaylist_at_id"></div>
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
    <div id="my-playlist-list"><a title="Xem danh sách Playlist của bạn" href="./playlist-cua-toi.html">XEM DANH SÁCH
            PLAYLIST CỦA BẠN</a></div>
</div>
<script type="text/javascript" src="/web/js/myfunction.js"></script>
<script>
    var p = 1;
    $(document).ready(function () {
        $('#hideMoreLyric').hide();
        loadComment();

    });
    //change quanlity
    function changeQuality(obj, dataItem) {
        var player = $("#jquery_jplayer");
        var audioRrl = $(obj).attr("data-media-src");
        var currentTime = jplayerCurrentTime();
        var quality = $(obj).attr("data-media-type");
        if (!audioRrl)
            audioRrl = dataItem['direct_media_url'];
        //set active icon quanlity
        $('.media_quality_select').removeAttr('style');

        $(obj).attr('style', 'color: #B302CB');
        player.jPlayer("setMedia", {
            mp3: audioRrl
        });
        player.jPlayer("play", currentTime);
        Cookies.set('jPlayer-audio-quality', quality, {expires: 7});
    }
    function jplayerCurrentTime() {
        var currentTime = $(".jp-current-time").text();
        var elems = currentTime.split(":");
        return parseInt(elems[0]) * 60 + parseInt(elems[1]);
    }
    function showlogin() {
        $(".cd-signin").click();
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
    function likeSong(obj) {
        var checklike = $(obj).attr('checklike');
        var atid = $(obj).data('id');
//        var type = $('#type').val();
        var type = 'audio';

        $.get("/incoming/likearticle", {atid: atid, checklike: checklike, type: type}, function (re) {
            if (re.status == 200) {
                if (checklike == 0) {
                    $(obj).attr('checklike', 1);
                    $(obj).attr('id', 'icon-active');
                    $(obj).attr('title', 'Đã thích');
                }
                else if (checklike == 1) {
                    $(obj).attr('checklike', 0);
                    $(obj).removeAttr('id');
                    $(obj).attr('title', 'Thích');
                }
            }
            else {
                alert(re.mss);
            }
        });
    }
    function Nominations_song(obj) {
//        var type = $('#type').val();
        var type = 'audio';
        var atid = $(obj).data('id');
        $.post("/incoming/nominations", {atid: atid, type: type}, function (re) {
            if (re.status == 200) {
                $(obj).attr('id', 'icon-active');
                $(obj).attr('title', 'Đã đề cử');
            }
            else {
                alert(re.mss);
            }
        });
    }

</script>