<link rel="stylesheet" href="/web/skins/jplayer.css" type="text/css"/>

<script type="text/javascript" src="/web/playlist/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="/web/js/jplayer.playlist.js"></script><script type="text/javascript">
    //<![CDATA[
    $(document).ready(function () {

        new jPlayerPlaylist({
            jPlayer: "#jquery_jplayer",
            cssSelectorAncestor: "#jp_container"
        }, [
            {% for key,item in listSong %}
            {
                title: "{{ item['name'] }}",
                artist: "{{ item['usercreate'] }}",
                free: true,
                id: "{{ item['_id'] }}",
                checklike: "{{ item['checklike'] }}",
                nominations: "{{ item['nominations'] }}",
                link: "{{ item['link'] }}",
                mp3: "{{ item['url'] }}"
            },
            {% endfor %}
        ], {
            playlistOptions: {
//                enableRemoveControls: true,
                autoPlay: true,
                displayItemAction: function (elem) {
                    return '<span class="wolf-jp-song-url">'
                            + '<a class="addplaylist" href="javascript:;" title="Thêm vào" onclick="showFormAddPlaylist(' + elem.id + ');"></a>'
                            + '<a class="like" ' + (elem.checklike == 1 ? 'id="icon-active"' : '') + ' checklike="' + elem.checklike + '"'
                            + 'href="javascript:;" ' + (elem.checklike == 1 ? 'title="Đã like"' : title="Like") + ' data-id="' + elem.id + '" onclick="likeMedia(this);" ></a>'
                            + '<a class="decu" ' + (elem.nominations == 1 ? 'id="icon-active"' : '') + ' ' + (elem.nominations == 1 ? 'title="Đã đề cử"' : 'title="Đề cử"') + ' href="javascript:;" onclick="Nominations(this)" data-id="' + elem.id + '" ></a>'
                            + '<a class="taive" href="/download.html?id=' + elem.id + '" title="Tải về" target="_blank"></a>'
                            + '<a class="share" href="#" title="Chia sẻ" target="_blank"></a>'
                            + '<a class="popup" href="' + elem.link + '" title="Nghe cửa sổ mới" target="_blank"></a>'
                            + '</span>';
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
            keyEnabled: true
        });
    });
    //]]>
</script>

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
<input type="hidden" id="type" value="topic" />
<div id="content">
    <div class="bgclr"></div>
    <div class="bg-cmmusic">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/trang-chu.html"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/chu-de.html">Tuyển tập chủ đề</a></li>
            </ul>
        </div>

        <div class="container">
            <div class="row">

                <article class="col-md-9 col-sm-9">
                    <div class="row">
                        <div class="col-md-5 col-sm-12">
                            <div class="play-list" style="width: 320px;">
                                <div class="album" style="width: 100%;">
                                    <div class="record rotate"></div>
                                    <img class="cover" src="/web/images/img4.jpg" title="" alt="">

                                    <div class="glass"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12">
                            <div class="info-song-top">
                                <h2>{{ object.name }}<span class="bull">-</span> <a href="#">{{ usercreate }}</a></h2>

                                <div class="info-pd-top">
                                    <span>Phát hành: </span>

                                    <div class="inline" itemprop="copyrightYear">8-2015</div>
                                    <span class="bull">•</span> <span>Thể loại: </span>

                                    <div class="inline">
                                        {% for item in listcategory %}
                                       <h3><a href="{{ item['link'] }}" title="{{ item['name'] }}">{{ item['name'] }}</a></h3>
                                       <span>,</span>
                                       </h3>
                                       {% endfor %}
                                    </div>
                                    <p></p>

                                    <p><i class="fa fa-headphones"></i> Lượt nghe: {{ object.view }}</p>

                                    <p><i class="fa fa-thumbs-up"></i> Thích: {{ object.like }}</p>

                                    <p><i class="fa fa-thumbs-down"></i> Không thích: {{ object.dislike }}</p>

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
                                    <div class="ab-rotate rotate"></div>
                                    <div class="gl"></div>
                                    {#<a href="#" class="wolf-jp-popup" title="Nghe cửa sổ mới"></a>#}

                                    <div class="jp-type-playlist">
                                        <div class="jp-gui jp-interface">
                                            <ul class="jp-controls">
                                                <li><a href="javascript:;" class="jp-previous" tabindex="1"></a></li>
                                                <li><a href="javascript:;" class="jp-play" tabindex="1"></a></li>
                                                <li><a href="javascript:;" class="jp-pause" tabindex="1"
                                                       style="display: none;"></a></li>
                                                <li><a href="javascript:;" class="jp-next" tabindex="1"></a></li>
                                                <li><a href="javascript:;" class="jp-stop" tabindex="1"></a></li>
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
                                                <li><a href="javascript:;" class="jp-shuffle" tabindex="1"
                                                       title="shuffle"></a></li>
                                                <li><a href="javascript:;" class="jp-shuffle-off" tabindex="1"
                                                       title="shuffle off" style="display: none;"></a></li>
                                                <li><a href="javascript:;" class="jp-repeat" tabindex="1"
                                                       title="repeat"></a></li>
                                                <li><a href="javascript:;" class="jp-repeat-off" tabindex="1"
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
                    {% include "/layouts/comment.volt" %}
                    <div class="td_heading"><h2><a href="#">Album khác</a><i class="fa fa-angle-right"></i></h2></div>

                    <div class="row slide-cmmusic">
                        <div class="featuredNavigation">
                            <a class="prev left recommended-item-control" title="Prev" id="prev"><i class="fa fa-angle-left"></i></a>
                            <a class="next right recommended-item-control" title="Next" id="next"><i class="fa fa-angle-right"></i></a>
                        </div>
                        <div id="slidemusic" class="our-listing owl-carousel">
                            {% for item in listalbum %}
                                <div class="block-music mr10">
                                    <div class="cover-outer-align">
                                        <img class="img-responsive" src="{{ item['priavatar'] }}" alt="{{ item['name'] }}"/>
                                           <span class="icon-circle-play">
                                               <a class="button" href="{{ item['link'] }}" title=""><i class="fa fa-play"></i></a>
                                           </span>
                                    </div>

                                    <div class="details">
                                        <h3><a href="{{ item['link'] }}" class="title tooltip-top" title="{{ item['name'] }}">{{ item['name'] }}
                                                <span class="paragraph-end"></span></a></h3>

                                        <div><a class="subtitle" href="{{ item['link'] }}" title="{{ item['usercreate'] }}">{{ item['usercreate'] }}</a></div>
                                    </div>
                                </div>
                            {% endfor %}
                        </div>
                        <!-- /.our-listing -->

                    </div>

                </article>
                <!-- End-article -->

                {% include 'layouts/siderbar_right.volt' %}

            </div>
        </div>
    </div>

</div>

<!--===================footer=====================-->

{% include 'layouts/footer.volt' %}

<input type="hidden" id="atid">
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
    function showFormAddPlaylist(atid) {
        $('#my-playlist-box').show();
        $('.wrap-playlist').remove();
        $('#atid').val(atid);
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
        $.get("/incoming/addplaylist", {name: name}, function (re) {
            var result = re.data;
            var html = '';
            if (re.status == 200) {
                html +=
                        '<div style="overflow: hidden; width: auto; height: auto;" id="playlist-list">' +
                        '<div class="playlist-list-item">' +
                        '<div class="playlist-list-name">' +
                        '<a title="Thử Playlist mới" onclick="addSoongToPlaylist(+results._id+)" href="javascript:void(0);">' +
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
    function addSoongToPlaylist(plid, type) {
        console.log(type);
        var atid = $('#atid').val();
        $.get("/incoming/addsoongtoplaylist", {pllid: plid, atid: atid, type: type}, function (re) {
            if (re.status == 200) {
                alert('Thêm nhạc vào playlist thành công!');
            }
            else {
                alert(re.mss);
            }
        });
    }
    var p = 1;
    $(document).ready(function () {
        loadComment();
    });
    function loadComment() {
        //check button viewmore comment
        var totalpage = {{ total_page_comment }};
        var atid = {{ object._id}};
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
    function likeMedia(obj) {
        var checklike = $(obj).attr('checklike');
        var atid = $(obj).data('id');
        var type = $('#type').val();

        $.get("/incoming/likemedia", {atid: atid, checklike: checklike, type: type}, function (re) {
            if (re.status == 200) {
                if (checklike == 0) {
                    $(obj).attr('checklike', 1);
                    $(obj).attr('id','icon-active');
                    $(obj).attr('title','Đã thích');
                }
                else if (checklike == 1) {
                    $(obj).attr('checklike', 0);
                    $(obj).removeAttr('id');
                    $(obj).attr('title','Thích');
                }
            }
            else {
                alert(re.mss);
            }
        });
    }
    function Nominations(obj) {
        var type = $('#type').val();
        var atid = $(obj).data('id');
        $.post("/incoming/nominations", {atid: atid, type: type}, function (re) {
            if (re.status == 200) {
                $(obj).attr('id','icon-active');
                $(obj).attr('title','Đã đề cử');
            }
            else {
                alert(re.mss);
            }
        });
    }
</script>