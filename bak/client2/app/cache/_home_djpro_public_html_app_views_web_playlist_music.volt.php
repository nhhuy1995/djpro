<link rel="stylesheet" href="/web/skins/jplayer.css" type="text/css"/>
<script type="text/javascript" src="/web/playlist/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="/web/js/jplayer.playlist.js"></script>
<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function () {
        var repeat = Cookies.get('jPlayer-audio-repeat');
        if (repeat == 'true')
            repeat = true;
        else
            repeat = false;

        var playlistPlayer = new jPlayerPlaylist({
            jPlayer: "#jquery_jplayer",
            cssSelectorAncestor: "#jp_container"
        }, [
            <?php foreach ($listSong as $key => $item) { ?>
            {
                title: "<?php echo $key + 1; ?>. <?php echo $item['name']; ?>",
                artistname: "<?php echo $item['listartist']['username']; ?>",
                artistlink: "<?php echo $item['listartist']['link']; ?>",
                free: true,
                id: "<?php echo $item['_id']; ?>",
                checklike: "<?php echo $item['checklike']; ?>",
                nominations: "<?php echo $item['nominations']; ?>",
                link: "<?php echo $item['link']; ?>",
                mp3: "<?php echo $item['direct_media_url']; ?>"
            },
            <?php } ?>
        ], {
            loop: repeat,
            playlistOptions: {
//                enableRemoveControls: true,
                autoPlay: true,
                displayItemAction: function (elem) {
                    return '<span class="wolf-jp-song-url">'
                            <?php if ($session['_id']) { ?>
                            + '<a class="addplaylist" href="javascript:void(0)" title="Thêm vào" onclick="showFormAddPlaylist(' + elem.id + ');"></a>'
                            + '<a class="like" ' + (elem.checklike == 1 ? 'id="icon-active"' : '') + ' checklike="' + elem.checklike + '"'
                            + 'href="javascript:void(0)" ' + (elem.checklike == 1 ? 'title="Đã like"' : title = "Like") + ' data-id="' + elem.id + '" onclick="likeSong(this);" ></a>'
                            + '<a class="decu" ' + (elem.nominations == 1 ? 'id="icon-active"' : '') + ' ' + (elem.nominations == 1 ? 'title="Đã đề cử"' : 'title="Đề cử"') + ' href="javascript:void(0)" onclick="Nominations_song(this)" data-id="' + elem.id + '" ></a>'
                            <?php } else { ?>
                            + '<a class="addplaylist" href="javascript:void(0)" title="Thêm vào" onclick="showlogin()"></a>'
                            + '<a onclick="showlogin()" class="like" ' + (elem.checklike == 1 ? 'id="icon-active"' : '') + ' checklike="' + elem.checklike + '"'
                            + 'href="javascript:void(0)" ' + (elem.checklike == 1 ? 'title="Đã like"' : title = "Like") + ' data-id="' + elem.id + '" ></a>'
                            + '<a onclick="showlogin()" class="decu" ' + (elem.nominations == 1 ? 'id="icon-active"' : '') + ' ' + (elem.nominations == 1 ? 'title="Đã đề cử"' : 'title="Đề cử"') + ' href="javascript:void(0)" data-id="' + elem.id + '" ></a>'
                            <?php } ?>
                            + '<a class="taive" href="/download.html?id=' + elem.id + '" title="Tải về" target="_blank"></a>'
                            + '<a class="share" href="javascript:void(0)" title="Chia sẻ" target="_blank"></a>'
                            + '<a class="popup" href="' + elem.link + '" title="Nghe cửa sổ mới" target="_blank"></a>'
                            + '</span>';


                },
                playItemCallback: function (item) {
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
                                        + 'data-media-type="' + type +  '"> ' +  label + ' </a></li>';
                            }

                            if (data.media_link_320k != undefined)
                                htmlQuality += insertMediaLink(data.media_link_320k, '320', '320k');
                            if (data.media_link_128k != undefined)
                                htmlQuality += insertMediaLink(data.media_link_128k, '128', '128k');
                            if (data.media_link_64k != undefined)
                                htmlQuality += insertMediaLink(data.media_link_64k, '64', '64k');

                            htmlQuality += '</ul></div>';
                            $('.dropdownContain').html(htmlQuality);

                            var quality =  Cookies.get('jPlayer-audio-quality');
                            if (typeof quality == 'string' && quality != 'undefined') {
                                if (typeof data['media_link_' + quality + 'k'] != 'undefined') {
                                    changeQuality(".media_quality_select[data-media-type='" + quality + "']");
                                }

                            }
                        } else {
                            alert(re.msg);
                        }
                    });
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
    });
    //]]>
</script>

<header id="header">
    <section class="bg <?php echo $class; ?>">
        <div class="navbar">
            <div class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-3"><h1 class="logo">DJ.PRO.VN</h1></div>
                        <div class="col-md-5 col-sm-4">
                            <form action="/tim-kiem.html" method="get" class="search" id="frmsearch">
                                <input type="text" autocomplete="off" onkeypress="searchsugget(this)" value="<?php echo $_GET['q']; ?>"  placeholder="--- Nhập từ khóa ---"
                                       name="q">

                                <div id="suggession_seach"></div>
                                <a href="javascript:void(0)" onclick="searchsubmit()"><i class="fa fa-search"></i></a>
                            </form>
                        </div>
                        <div class="col-md-4 col-sm-5">

                            <div class="col-mobile">
                                <?php if ($session['_id']) { ?>
                                    <ul class="navuser">
                                        <li><a href="/user.html"><img src="<?php echo $session['priavatar']; ?>"
                                                                     alt=""/> <?php echo $session['username']; ?></a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                                        class="fa fa-cog"></i>Bảng điều khiển</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="/user.html"><i class="fa fa-info"></i> Thông tin cá nhân</a>
                                                </li>
                                                <li class="pull-right"><a href="javascript:void(0)" data-toggle="modal" data-target="#postmusic"><i class="fa fa-upload"></i> Đăng nhạc</a>
                                                </li>
                                                <li><a href="/playlist-cua-toi.html"><i class="fa fa-music"></i>
                                                        Playlist của bạn</a></li>
                                                <li><a href="/nhac-da-duyet.html"><i
                                                                class="fa fa-microphone"></i> Nhạc đã duyệt</a>
                                                </li>
                                                <li><a href="/nhac-cho-duyet.html"><i
                                                                class="fa fa-microphone"></i> Nhạc chờ duyệt</a>
                                                </li>
                                                <li><a href="/nhac-da-xoa.html"><i
                                                                class="fa fa-microphone"></i> Nhạc đã xóa</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#require_music"><i
                                                                class="fa fa-pencil-square-o "></i> Yêu cầu nhạc</a>
                                                </li>
                                                <li><a href="/doi-mat-khau.html"><i class="fa fa-key"></i> Đổi mật khẩu</a>
                                                </li>
                                                <li><a onclick="return confirm('Bạn chắc chắn muốn thoát?')" href="/logout.html"><i class="fa fa-sign-out"></i> Thoát</a></li>
                                            </ul>
                                        </li>
                                    </ul><!--đã login-->
                                <?php } else { ?>
                                    <ul class="main-nav">
                                        <li><a href="javascript:void(0)" class="cd-signup"><i class="fa fa-user"></i> Đăng ký</a>|</li>
                                        <li><a href="javascript:void(0)" class="cd-signin"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                                    </ul>
                                <?php } ?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End-header-top-->
            <div class="navbar-header">
                <div class="container">
                    <button data-target=".navbar-collapse" data-toggle="collapse"
                            class="navbar-toggle btn responsive-menu collapsed" type="button">
                        <span class="sr-only">menu</span>
                    </button>

                </div>
                <!-- /.container -->
            </div>
            <!-- /.navbar-header -->
            <div id="sticky-menu" class="navbar-collapse collapse">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="sm sm-clean" id="main-menu">
                                <li><a href="/trang-chu.html" class="active"><i class="fa fa-home"></i></a></li>
                                <?php foreach ($listcategory_header as $item) { ?>
                                    <li>
                                        <a href="/<?php echo $item['link']; ?>" class="has-submenu">
                                            <?php if (isset($item['child'])) { ?>
                                                <span class="sub-arrow">+</span>
                                            <?php } ?>
                                            <?php echo $item['title']; ?>
                                        </a>
                                        <?php if (isset($item['child'])) { ?>
                                            <ul>
                                                <?php if ($item['countchildcolumn'] <= 1) { ?>
                                                    <?php foreach ($item['child'] as $itemchild) { ?>
                                                        <li>
                                                            <a href="<?php echo $itemchild['link']; ?>"><?php echo $itemchild['title']; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <li>
                                                        <!-- The mega drop down contents -->
                                                        <div class="mega-menu colum<?php echo $item['countchildcolumn']; ?>">
                                                            <?php $cssColumn = 12 / $item['countchildcolumn']; ?>
                                                            <?php $cssColumn = 'col-md-' . $cssColumn . ' col-sm-' . $cssColumn; ?>
                                                            <?php $v117578330369560508912iterator = $item['child']; $v117578330369560508912incr = 0; $v117578330369560508912loop = new stdClass(); $v117578330369560508912loop->length = count($v117578330369560508912iterator); $v117578330369560508912loop->index = 1; $v117578330369560508912loop->index0 = 1; $v117578330369560508912loop->revindex = $v117578330369560508912loop->length; $v117578330369560508912loop->revindex0 = $v117578330369560508912loop->length - 1; ?><?php foreach ($v117578330369560508912iterator as $indexItemChild => $itemchild) { ?><?php $v117578330369560508912loop->first = ($v117578330369560508912incr == 0); $v117578330369560508912loop->index = $v117578330369560508912incr + 1; $v117578330369560508912loop->index0 = $v117578330369560508912incr; $v117578330369560508912loop->revindex = $v117578330369560508912loop->length - $v117578330369560508912incr; $v117578330369560508912loop->revindex0 = $v117578330369560508912loop->length - ($v117578330369560508912incr + 1); $v117578330369560508912loop->last = ($v117578330369560508912incr == ($v117578330369560508912loop->length - 1)); ?>
                                                                <?php if ($indexItemChild % 6 == 0) { ?>
                                                                    <div class="<?php echo $cssColumn; ?> col-xs-12">
                                                                    <div class="bvmenu">
                                                                <?php } ?>
                                                                <a href="<?php echo $itemchild['link']; ?>"><?php echo $itemchild['title']; ?></a>
                                                                <?php if ($indexItemChild % 6 == 5 || $v117578330369560508912loop->last) { ?>
                                                                    </div>
                                                                    </div>
                                                                <?php } ?>
                                                            <?php $v117578330369560508912incr++; } ?>
                                                        </div>
                                                    </li>
                                                <?php } ?>

                                            </ul>
                                        <?php } ?>
                                    </li>
                                <?php } ?>

                            </ul>
                            <!-- /.nav -->
                            <?php if ($session['_id']) { ?>
                                <div class="pull-right"><i class="fa fa-cloud-upload fa-lg"></i>
                                    <a data-target="#postmusic" data-toggle="modal" href="javascript:void(0)"> Đăng nhạc!</a>
                                </div>
                            <?php } else { ?>
                                <div class="pull-right main-nav"><i class="fa fa-cloud-upload fa-lg"></i>
                                    <a class="cd-login" href="javascript:void(0)"> Đăng nhạc!</a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.sticky-menu -->
        </div>
        <!-- /.navbar-collapse -->

    </section>
</header>

<input type="hidden" id="type" value="<?php echo $object->type; ?>"/>
<div id="content">
    <div class="bgclr"></div>
    <div class="bg-cmmusic">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/trang-chu.html"><i class="fa fa-home fa-lg"></i></a></li>
                <?php if ($object->type == 'album') { ?>
                    <li><a href="/album.html">Album</a></li>
                <?php } elseif ($object->type == 'playlist') { ?>
                    <li><a href="/playlist.html">Playlist</a></li>
                <?php } elseif ($object->type == 'topic') { ?>
                    <li><a href="/chu-de.html">Chủ đề</a></li>
                <?php } ?>
                <?php if ($listcategory) { ?>
                    <?php foreach ($listcategory as $item) { ?>
                        <li><a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>"
                               alt="<?php echo $item['name']; ?>"><?php echo $item['name']; ?></a></li>
                    <?php } ?>
                <?php } else { ?>
                    <li>Đang cập nhật!</li>
                <?php } ?>
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
                                    <img class="cover" src="<?php echo $object->priavatar; ?>" title="<?php echo $object->name; ?>"
                                         alt="<?php echo $object->name; ?>">

                                    <div class="glass"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12">
                            <div class="info-song-top">
                                <h2><?php echo $object->name; ?>
                                    <?php if ($listartist) { ?>
                                    <span class="bull">-</span>
                                    <?php $v117578330369560508911iterator = $listartist; $v117578330369560508911incr = 0; $v117578330369560508911loop = new stdClass(); $v117578330369560508911loop->length = count($v117578330369560508911iterator); $v117578330369560508911loop->index = 1; $v117578330369560508911loop->index0 = 1; $v117578330369560508911loop->revindex = $v117578330369560508911loop->length; $v117578330369560508911loop->revindex0 = $v117578330369560508911loop->length - 1; ?><?php foreach ($v117578330369560508911iterator as $item) { ?><?php $v117578330369560508911loop->first = ($v117578330369560508911incr == 0); $v117578330369560508911loop->index = $v117578330369560508911incr + 1; $v117578330369560508911loop->index0 = $v117578330369560508911incr; $v117578330369560508911loop->revindex = $v117578330369560508911loop->length - $v117578330369560508911incr; $v117578330369560508911loop->revindex0 = $v117578330369560508911loop->length - ($v117578330369560508911incr + 1); $v117578330369560508911loop->last = ($v117578330369560508911incr == ($v117578330369560508911loop->length - 1)); ?>
                                    <a href="<?php echo $item['link']; ?>"
                                       title="<?php echo $item['username']; ?>"><?php echo $item['username']; ?></a>
                                    <span class="bull"><?php if (!$v117578330369560508911loop->last) { ?>Ft <?php } ?></span>
                                    <?php $v117578330369560508911incr++; } ?>
                                    <?php } ?>
                                </h2>

                                <div class="info-pd-top">
                                    <span>Phát hành: </span>

                                    <div class="inline"
                                         itemprop="copyrightYear"><?php echo date('d-m-Y', $object->datecreate); ?></div>
                                    <span class="bull">•</span> <span>Thể loại: </span>

                                    <div class="inline">
                                        <?php if ($listcategory) { ?>
                                        <?php $v117578330369560508911iterator = $listcategory; $v117578330369560508911incr = 0; $v117578330369560508911loop = new stdClass(); $v117578330369560508911loop->length = count($v117578330369560508911iterator); $v117578330369560508911loop->index = 1; $v117578330369560508911loop->index0 = 1; $v117578330369560508911loop->revindex = $v117578330369560508911loop->length; $v117578330369560508911loop->revindex0 = $v117578330369560508911loop->length - 1; ?><?php foreach ($v117578330369560508911iterator as $item) { ?><?php $v117578330369560508911loop->first = ($v117578330369560508911incr == 0); $v117578330369560508911loop->index = $v117578330369560508911incr + 1; $v117578330369560508911loop->index0 = $v117578330369560508911incr; $v117578330369560508911loop->revindex = $v117578330369560508911loop->length - $v117578330369560508911incr; $v117578330369560508911loop->revindex0 = $v117578330369560508911loop->length - ($v117578330369560508911incr + 1); $v117578330369560508911loop->last = ($v117578330369560508911incr == ($v117578330369560508911loop->length - 1)); ?>
                                        <h3>
                                            <a href="<?php echo $item['link']; ?>"
                                               title="<?php echo $item['name']; ?>"><?php echo $item['name']; ?></a><?php if (!$v117578330369560508911loop->last) { ?>,<?php } ?>
                                        </h3>
                                        <?php $v117578330369560508911incr++; } ?>
                                    <?php } else { ?>
                                        <h3>
                                            Đang cập nhật!
                                        </h3>
                                        <?php } ?>
                                    </div>
                                    <p></p>

                                    <p class="boutdownload"><i class="fa fa-headphones"></i> Lượt
                                        nghe: <?php echo $object->view; ?></p>

                                    <p class="boutlike"><i class="fa fa-thumbs-up"></i> Thích: <?php echo $object->like; ?></p>

                                    <p class="boutdislike"><i class="fa fa-thumbs-down"></i> Không
                                        thích: <?php echo $object->dislike; ?></p>

                                    <p>
                                    <p class="boutdislike"><i class="fa fa-user"></i> Người gửi:
                                        <a href="<?php echo $object->usercreatelink; ?>"
                                           style="<?php if ($object->is_role == 1) { ?> color: #c73030;<?php } else { ?> color: #176093;<?php } ?>"
                                           title="<?php echo $object->usercreate; ?>"><?php echo $object->usercreate; ?></a>
                                        <span class="role_user"><?php echo $object->usercreate_namerole; ?></span>
                                    <p>
                                    <div class="fb-like" data-href="<?php echo $currentLink; ?>" data-layout="button_count"
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
                        <input type="hidden" id="url_article" value="<?php echo $currentLink; ?>"/>
                        <?php if ($session['_id']) { ?>
                            <ul class="media-func">
                                <li><i class="fa fa-plus"></i> <a href="javascript:void(0)"
                                                                  onclick="showFormAddPlaylist(<?php echo $object->_id; ?>)">Thêm
                                        vào</a></li>
                                <li><i class="fa fa-thumbs-up"
                                       id="icon-like" <?php if ($check_like->_id) { ?> style="color: blue;" <?php } ?>></i>
                                    <a href="javascript:void(0)" onclick="likeArticle(this);" data-id="<?php echo $object->_id; ?>"
                                       checklike="<?php echo ($check_like->_id > 0 ? 1 : 0); ?>">Thích</a>
                                </li>
                                <li><i class="fa fa-thumbs-down"
                                       id="icon-dislike" <?php if ($check_dislike->_id) { ?> style="color: blue;" <?php } ?>></i>
                                    <a href="javascript:void(0)" onclick="dislikeArticle(this);"
                                       data-id="<?php echo $object->_id; ?>"
                                       checklike="<?php echo ($check_dislike->_id > 0 ? 1 : 0); ?>">Không thích</a>
                                </li>
                                <li><i class="fa fa-star"
                                       id="icon-nominations" <?php if ($check_nominations->_id) { ?> style="color: blue;" <?php } ?>></i>
                                    <a href="javascript:void(0)" onclick="Nominations(<?php echo $object->_id; ?>);">Đề
                                        cử</a>
                                </li>
                                
                                <?php if ($session['_id']) { ?>
                                    <li>
                                        <i class="fa fa-flag"></i> <a data-target="#sendfeedback" data-toggle="modal"
                                                                      href="javascript:void(0)">Báo lỗi</a>
                                    </li>
                                <?php } else { ?>
                                    <li class="main-nav">
                                        <i class="fa fa-flag"></i> <a class="cd-signin" href="javascript:void(0)">Báo
                                            lỗi</a>
                                    </li>
                                <?php } ?>
                                
                                <li><i class="fa fa-share-alt"></i> <a href="javascript:void(0)"
                                                                       onclick="share_facebook()">Chia sẻ</a></li>
                            </ul>
                        <?php } else { ?>
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
                                
                                <li><i class="fa fa-share-alt"></i> <a href="javascript:void(0)"
                                                                       onclick="share_facebook()">Chia sẻ</a></li>
                            </ul>
                        <?php } ?>
                    </div>
                    <?php if ($listags) { ?>
                        <div class="tags"><strong><i class="fa fa-tags"></i> Tags:</strong>
                            <?php $v117578330369560508911iterator = $listags; $v117578330369560508911incr = 0; $v117578330369560508911loop = new stdClass(); $v117578330369560508911loop->length = count($v117578330369560508911iterator); $v117578330369560508911loop->index = 1; $v117578330369560508911loop->index0 = 1; $v117578330369560508911loop->revindex = $v117578330369560508911loop->length; $v117578330369560508911loop->revindex0 = $v117578330369560508911loop->length - 1; ?><?php foreach ($v117578330369560508911iterator as $item) { ?><?php $v117578330369560508911loop->first = ($v117578330369560508911incr == 0); $v117578330369560508911loop->index = $v117578330369560508911incr + 1; $v117578330369560508911loop->index0 = $v117578330369560508911incr; $v117578330369560508911loop->revindex = $v117578330369560508911loop->length - $v117578330369560508911incr; $v117578330369560508911loop->revindex0 = $v117578330369560508911loop->length - ($v117578330369560508911incr + 1); $v117578330369560508911loop->last = ($v117578330369560508911incr == ($v117578330369560508911loop->length - 1)); ?>
                                <a href="<?php echo $item['link']; ?>"><?php echo $item['name']; ?></a>
                            <?php $v117578330369560508911incr++; } ?>
                        </div>
                    <?php } ?>
                    <?php if ($listSong) { ?>
                        <div style="min-height: 331px;" class="lyric">
                            <div class="pd_name_lyric">
                            </div>


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
                    <?php } ?>
                    <script type="text/javascript" src="/web/js/cbpFWTabs.js"></script>
<div class="td_heading"><h2><a href="#">Bình luận</a><i class="fa fa-angle-right"></i></h2></div>
<div class="tabs tabs-style-tzoid">
    <nav>
        <ul>
            <li class=""><a href="#section-tzoid-1"><span>Thành viên bình luận (<?php echo $total_comment; ?>)</span></a></li>
            <li class=""><a href="#section-tzoid-2"><span>Facebook</span></a></li>
            
        </ul>
    </nav>
    <div class="content-wrap">
        <input type="hidden" id="session_username" value="<?php echo $session['username']; ?>">
        <section class="" id="section-tzoid-1">
            <ul class="row bv-comment">
                <li class="col-md-12">
                                        <textarea id="content_comment"
                                                  onfocus="if (this.value==this.defaultValue) this.value = ''"
                                                  onblur="if (this.value=='') this.value = this.defaultValue"
                                                  placeholder="Nội dung comment"></textarea>
                </li>
                <?php if ($session['_id']) { ?>
                    <li class="col-md-12"><input type="submit" value="Gửi ngay" onclick="sendComment(this);"
                                                 data-id="<?php echo $object->_id; ?>"
                                                 class="button-cm">
                    </li>
                <?php } else { ?>
                    <li class="col-md-12 main-nav"><input type="submit" value="Gửi ngay" class="button-cm cd-login">
                    </li>
                <?php } ?>
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
            <div class="fb-comments" data-href="http://<?php echo $this->config->application->site . $object->link; ?>" data-width="100%" data-numposts="5"></div>
            
            <p></p>
        </section>
        
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
                    <div class="td_heading">
                        <h2>
                            <?php if ($object->type == 'topic') { ?>
                                <a href="/chu-de.html">Chủ đề khác</a>
                            <?php } elseif ($object->type == 'album') { ?>
                                <a href="/album.html">Album khác</a>
                            <?php } elseif ($object->type == 'playlist') { ?>
                                <a href="/playlist.html">Playlist khác</a>
                            <?php } ?>
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
                            <?php $v117578330369560508911iterator = $listalbum; $v117578330369560508911incr = 0; $v117578330369560508911loop = new stdClass(); $v117578330369560508911loop->length = count($v117578330369560508911iterator); $v117578330369560508911loop->index = 1; $v117578330369560508911loop->index0 = 1; $v117578330369560508911loop->revindex = $v117578330369560508911loop->length; $v117578330369560508911loop->revindex0 = $v117578330369560508911loop->length - 1; ?><?php foreach ($v117578330369560508911iterator as $item) { ?><?php $v117578330369560508911loop->first = ($v117578330369560508911incr == 0); $v117578330369560508911loop->index = $v117578330369560508911incr + 1; $v117578330369560508911loop->index0 = $v117578330369560508911incr; $v117578330369560508911loop->revindex = $v117578330369560508911loop->length - $v117578330369560508911incr; $v117578330369560508911loop->revindex0 = $v117578330369560508911loop->length - ($v117578330369560508911incr + 1); $v117578330369560508911loop->last = ($v117578330369560508911incr == ($v117578330369560508911loop->length - 1)); ?>
                                <div class="block-music mr10">
                                    <div class="cover-outer-align">
                                        <a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>">
                                            <img class="img-responsive" src="<?php echo $item['priavatar']; ?>"
                                                 alt="<?php echo $item['name']; ?>"/>
                                        </a>
                                           <span class="icon-circle-play">
                                               <a class="button" href="<?php echo $item['link']; ?>" title=""><i
                                                           class="fa fa-play"></i></a>
                                           </span>
                                    </div>

                                    <div class="details">
                                        <h3><a href="<?php echo $item['link']; ?>" class="title tooltip-top"
                                               title="<?php echo $item['name']; ?>"><?php echo $item['name']; ?>
                                                <span class="paragraph-end"></span></a></h3>
                                        <div class="hide-ns">
    <?php if ($item['listartist']) { ?>
    <?php $v117578330369560508911iterator = $item['listartist']; $v117578330369560508911incr = 0; $v117578330369560508911loop = new stdClass(); $v117578330369560508911loop->length = count($v117578330369560508911iterator); $v117578330369560508911loop->index = 1; $v117578330369560508911loop->index0 = 1; $v117578330369560508911loop->revindex = $v117578330369560508911loop->length; $v117578330369560508911loop->revindex0 = $v117578330369560508911loop->length - 1; ?><?php foreach ($v117578330369560508911iterator as $itemchild) { ?><?php $v117578330369560508911loop->first = ($v117578330369560508911incr == 0); $v117578330369560508911loop->index = $v117578330369560508911incr + 1; $v117578330369560508911loop->index0 = $v117578330369560508911incr; $v117578330369560508911loop->revindex = $v117578330369560508911loop->length - $v117578330369560508911incr; $v117578330369560508911loop->revindex0 = $v117578330369560508911loop->length - ($v117578330369560508911incr + 1); $v117578330369560508911loop->last = ($v117578330369560508911incr == ($v117578330369560508911loop->length - 1)); ?>
    <a class="subtitle" href="<?php echo $itemchild['link']; ?>"
       title="<?php echo $itemchild['username']; ?>"><?php echo $itemchild['username']; ?></a><?php if (!$v117578330369560508911loop->last) { ?><span class="bull" style="font-size:12px;">Ft </span><?php } ?>
    <?php $v117578330369560508911incr++; } ?>
    <span class="paragraph-end"></span>
    <?php } ?>
</div>
                                    </div>
                                </div>
                            <?php $v117578330369560508911incr++; } ?>
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
                            <?php $v117578330369560508911iterator = $listmusicbyview; $v117578330369560508911incr = 0; $v117578330369560508911loop = new stdClass(); $v117578330369560508911loop->length = count($v117578330369560508911iterator); $v117578330369560508911loop->index = 1; $v117578330369560508911loop->index0 = 1; $v117578330369560508911loop->revindex = $v117578330369560508911loop->length; $v117578330369560508911loop->revindex0 = $v117578330369560508911loop->length - 1; ?><?php foreach ($v117578330369560508911iterator as $item) { ?><?php $v117578330369560508911loop->first = ($v117578330369560508911incr == 0); $v117578330369560508911loop->index = $v117578330369560508911incr + 1; $v117578330369560508911loop->index0 = $v117578330369560508911incr; $v117578330369560508911loop->revindex = $v117578330369560508911loop->length - $v117578330369560508911incr; $v117578330369560508911loop->revindex0 = $v117578330369560508911loop->length - ($v117578330369560508911incr + 1); $v117578330369560508911loop->last = ($v117578330369560508911incr == ($v117578330369560508911loop->length - 1)); ?>
                            <li><a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>" class="thumb pull-left">
                                    <img src="<?php echo $item['priavatar']; ?>" alt="<?php echo $item['name']; ?>">
                                </a>

                                <h3 class="song-name"><a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>"
                                                         class="txt-primary"><?php echo $item['name']; ?></a>
                                </h3>

                                <div class="singer-name">
                                    <?php $v117578330369560508912iterator = $item['artist']; $v117578330369560508912incr = 0; $v117578330369560508912loop = new stdClass(); $v117578330369560508912loop->length = count($v117578330369560508912iterator); $v117578330369560508912loop->index = 1; $v117578330369560508912loop->index0 = 1; $v117578330369560508912loop->revindex = $v117578330369560508912loop->length; $v117578330369560508912loop->revindex0 = $v117578330369560508912loop->length - 1; ?><?php foreach ($v117578330369560508912iterator as $artist) { ?><?php $v117578330369560508912loop->first = ($v117578330369560508912incr == 0); $v117578330369560508912loop->index = $v117578330369560508912incr + 1; $v117578330369560508912loop->index0 = $v117578330369560508912incr; $v117578330369560508912loop->revindex = $v117578330369560508912loop->length - $v117578330369560508912incr; $v117578330369560508912loop->revindex0 = $v117578330369560508912loop->length - ($v117578330369560508912incr + 1); $v117578330369560508912loop->last = ($v117578330369560508912incr == ($v117578330369560508912loop->length - 1)); ?>
                                    <a href="<?php echo $artist['link']; ?>"><?php echo $artist['username']; ?></a><?php if (!$v117578330369560508912loop->last) { ?><span>Ft</span><?php } ?>
                                    <?php $v117578330369560508912incr++; } ?>
                                </div>

                            </li>
                            <?php $v117578330369560508911incr++; } ?>
                        </ul>

                    </div>
                    <div class="sidebar">
                        <h2 class="heading">Có thể bạn muốn nghe</h2>

                        <div class="main-boder">
                            <div data-special-type="app" class="player-container2">
                                <div data-special-type="app" class="player-container2">
                                    <ul class="listtop">

                                        <?php $v117578330369560508911iterator = $listMusic; $v117578330369560508911incr = 0; $v117578330369560508911loop = new stdClass(); $v117578330369560508911loop->length = count($v117578330369560508911iterator); $v117578330369560508911loop->index = 1; $v117578330369560508911loop->index0 = 1; $v117578330369560508911loop->revindex = $v117578330369560508911loop->length; $v117578330369560508911loop->revindex0 = $v117578330369560508911loop->length - 1; ?><?php foreach ($v117578330369560508911iterator as $key => $item) { ?><?php $v117578330369560508911loop->first = ($v117578330369560508911incr == 0); $v117578330369560508911loop->index = $v117578330369560508911incr + 1; $v117578330369560508911loop->index0 = $v117578330369560508911incr; $v117578330369560508911loop->revindex = $v117578330369560508911loop->length - $v117578330369560508911incr; $v117578330369560508911loop->revindex0 = $v117578330369560508911loop->length - ($v117578330369560508911incr + 1); $v117578330369560508911loop->last = ($v117578330369560508911incr == ($v117578330369560508911loop->length - 1)); ?>
                                            <?php $cl = 'special-4'; ?>
                                            <?php if ($key == 0) { ?> <?php $cl = 'special-1'; ?> <?php } ?>
                                            <?php if ($key == 1) { ?> <?php $cl = 'special-2'; ?> <?php } ?>
                                            <?php if ($key == 2) { ?> <?php $cl = 'special-3'; ?> <?php } ?>
                                            <li>
                                                <a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>"><span
                                                            class="number <?php echo $cl; ?>"><?php echo $key + 1; ?></span><?php echo $item['name']; ?>
                                                </a></li>
                                        <?php $v117578330369560508911incr++; } ?>
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

<footer>
    <div class="container">
        <div class="row">
            <?php $v117578330369560508911iterator = $listCategory_footer; $v117578330369560508911incr = 0; $v117578330369560508911loop = new stdClass(); $v117578330369560508911loop->length = count($v117578330369560508911iterator); $v117578330369560508911loop->index = 1; $v117578330369560508911loop->index0 = 1; $v117578330369560508911loop->revindex = $v117578330369560508911loop->length; $v117578330369560508911loop->revindex0 = $v117578330369560508911loop->length - 1; ?><?php foreach ($v117578330369560508911iterator as $index => $itemFooterMenu) { ?><?php $v117578330369560508911loop->first = ($v117578330369560508911incr == 0); $v117578330369560508911loop->index = $v117578330369560508911incr + 1; $v117578330369560508911loop->index0 = $v117578330369560508911incr; $v117578330369560508911loop->revindex = $v117578330369560508911loop->length - $v117578330369560508911incr; $v117578330369560508911loop->revindex0 = $v117578330369560508911loop->length - ($v117578330369560508911incr + 1); $v117578330369560508911loop->last = ($v117578330369560508911incr == ($v117578330369560508911loop->length - 1)); ?>
                <?php if ($index % 5 == 0) { ?>
                    <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="list1">
                <?php } ?>
                <li><a href="<?php echo $itemFooterMenu['link']; ?>"><?php echo $itemFooterMenu['title']; ?></a></li>
                <?php if ($index % 5 == 4 || $v117578330369560508911loop->last) { ?>
                    </ul>
                    </div>
                <?php } ?>
            <?php $v117578330369560508911incr++; } ?>

            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="share">
                    <h2>Share online</h2>
                    <ul class="social">
                        <li><a href="#" title="" class="tooltip-top" rel="nofollow"
                               data-original-title="Share Facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" title="" class="tooltip-top" rel="nofollow"
                               data-original-title="Share Google +"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#" title="" class="tooltip-top" rel="nofollow" data-original-title="Share Twitter"><i
                                        class="fa fa-twitter"></i></a></li>
                        <li><a href="#" title="" class="tooltip-top" rel="nofollow"
                               data-original-title="Share Instagram"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
                
                </p>
            </div>
        </div>
    </div>
</footer>



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
                        <input class="full-width has-padding" type="submit" value="Gửi" data-id="<?php echo $object->_id; ?>"
                               data-type="<?php echo $object->type; ?>" onclick="sendfeedback(this)">
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
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
    var p = 1;
    $(document).ready(function () {
        $('#hideMoreLyric').hide();
        loadComment();

    });
    //change quanlity
    function changeQuality(obj) {
        var player = $("#jquery_jplayer");
        var audioRrl = $(obj).attr("data-media-src");
        var currentTime = jplayerCurrentTime();
        var quality = $(obj).attr("data-media-type");
        //set active icon quanlity
        $('.media_quality_select').removeAttr('style');

        $(obj).attr('style','color: #B302CB');
        player.jPlayer("setMedia", {
            mp3: audioRrl
        });
        player.jPlayer("play", currentTime);
        Cookies.set('jPlayer-audio-quality', quality, { expires: 7 });
    }
    function jplayerCurrentTime() {
        var currentTime = $(".jp-current-time").text();
        var elems = currentTime.split(":");
        return parseInt(elems[0]) * 60 + parseInt(elems[1]);
    }
    function showlogin() {
        $(".cd-signin").click();
    }
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
    function loadComment() {
        //check button viewmore comment
        var totalpage = <?php echo $total_page_comment; ?>;
        var atid = <?php echo $object->_id; ?>;
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