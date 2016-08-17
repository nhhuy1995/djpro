<link rel="stylesheet" href="/web/skins/jplayer.css"/>
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
        if (repeat == 'true')
            repeat = true;
        else
            repeat = false;

        $("#jquery_jplayer").jPlayer({
            ready: function () {
                $(this).jPlayer("setMedia", {
                    title: "<?php echo $object->name; ?>",
                    mp3: "<?php echo $object->media_url; ?>",

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
                                                            <?php $v178023115292951147852iterator = $item['child']; $v178023115292951147852incr = 0; $v178023115292951147852loop = new stdClass(); $v178023115292951147852loop->length = count($v178023115292951147852iterator); $v178023115292951147852loop->index = 1; $v178023115292951147852loop->index0 = 1; $v178023115292951147852loop->revindex = $v178023115292951147852loop->length; $v178023115292951147852loop->revindex0 = $v178023115292951147852loop->length - 1; ?><?php foreach ($v178023115292951147852iterator as $indexItemChild => $itemchild) { ?><?php $v178023115292951147852loop->first = ($v178023115292951147852incr == 0); $v178023115292951147852loop->index = $v178023115292951147852incr + 1; $v178023115292951147852loop->index0 = $v178023115292951147852incr; $v178023115292951147852loop->revindex = $v178023115292951147852loop->length - $v178023115292951147852incr; $v178023115292951147852loop->revindex0 = $v178023115292951147852loop->length - ($v178023115292951147852incr + 1); $v178023115292951147852loop->last = ($v178023115292951147852incr == ($v178023115292951147852loop->length - 1)); ?>
                                                                <?php if ($indexItemChild % 6 == 0) { ?>
                                                                    <div class="<?php echo $cssColumn; ?> col-xs-12">
                                                                    <div class="bvmenu">
                                                                <?php } ?>
                                                                <a href="<?php echo $itemchild['link']; ?>"><?php echo $itemchild['title']; ?></a>
                                                                <?php if ($indexItemChild % 6 == 5 || $v178023115292951147852loop->last) { ?>
                                                                    </div>
                                                                    </div>
                                                                <?php } ?>
                                                            <?php $v178023115292951147852incr++; } ?>
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


<div id="content">
    <input type="hidden" class="articleId" value="<?php echo $object->_id; ?>"/>

    <div class="bgclr"></div>
    <div class="bg-cmmusic">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/trang-chu.html"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/bai-hat.html">Bài hát</a></li>
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
                                    <?php $v12593744712802147721iterator = $listartist; $v12593744712802147721incr = 0; $v12593744712802147721loop = new stdClass(); $v12593744712802147721loop->length = count($v12593744712802147721iterator); $v12593744712802147721loop->index = 1; $v12593744712802147721loop->index0 = 1; $v12593744712802147721loop->revindex = $v12593744712802147721loop->length; $v12593744712802147721loop->revindex0 = $v12593744712802147721loop->length - 1; ?><?php foreach ($v12593744712802147721iterator as $item) { ?><?php $v12593744712802147721loop->first = ($v12593744712802147721incr == 0); $v12593744712802147721loop->index = $v12593744712802147721incr + 1; $v12593744712802147721loop->index0 = $v12593744712802147721incr; $v12593744712802147721loop->revindex = $v12593744712802147721loop->length - $v12593744712802147721incr; $v12593744712802147721loop->revindex0 = $v12593744712802147721loop->length - ($v12593744712802147721incr + 1); $v12593744712802147721loop->last = ($v12593744712802147721incr == ($v12593744712802147721loop->length - 1)); ?>
                                    <a href="<?php echo $item['link']; ?>"
                                       title="<?php echo $item['username']; ?>"><?php echo $item['username']; ?></a>
                                    <span class="bull"><?php if (!$v12593744712802147721loop->last) { ?>Ft <?php } ?></span>

                                    <?php $v12593744712802147721incr++; } ?>
                                    <?php } ?>
                                </h2>

                                <div class="info-pd-top">
                                    <span>Phát hành: </span>

                                    <div itemprop="copyrightYear"
                                         class="inline"><?php echo date('d-m-Y', $object->datecreate); ?></div>
                                    <span class="bull">•</span> <span>Thể loại: </span>

                                    <div class="inline">
                                        <?php if ($listcategory) { ?>
                                        <?php $v12593744712802147721iterator = $listcategory; $v12593744712802147721incr = 0; $v12593744712802147721loop = new stdClass(); $v12593744712802147721loop->length = count($v12593744712802147721iterator); $v12593744712802147721loop->index = 1; $v12593744712802147721loop->index0 = 1; $v12593744712802147721loop->revindex = $v12593744712802147721loop->length; $v12593744712802147721loop->revindex0 = $v12593744712802147721loop->length - 1; ?><?php foreach ($v12593744712802147721iterator as $item) { ?><?php $v12593744712802147721loop->first = ($v12593744712802147721incr == 0); $v12593744712802147721loop->index = $v12593744712802147721incr + 1; $v12593744712802147721loop->index0 = $v12593744712802147721incr; $v12593744712802147721loop->revindex = $v12593744712802147721loop->length - $v12593744712802147721incr; $v12593744712802147721loop->revindex0 = $v12593744712802147721loop->length - ($v12593744712802147721incr + 1); $v12593744712802147721loop->last = ($v12593744712802147721incr == ($v12593744712802147721loop->length - 1)); ?>
                                        <h3>
                                            <a href="<?php echo $item['link']; ?>"
                                               title="<?php echo $item['name']; ?>"><?php echo $item['name']; ?></a><?php if (!$v12593744712802147721loop->last) { ?>,<?php } ?>
                                        </h3>
                                        <?php $v12593744712802147721incr++; } ?>
                                    <?php } else { ?>
                                        <h3>
                                            Đang cập nhật!
                                        </h3>
                                        <?php } ?>

                                    </div>
                                    <p></p>

                                    <p><i class="fa fa-headphones"></i> Lượt nghe: <?php echo $object->view; ?></p>

                                    <p class="boutdownload"><i class="fa fa-download"></i> Lượt
                                        tải: <?php echo $object->download; ?></p>
                                    <?php if ($session['_id']) { ?>
                                    <p class="boutlike"><i class="fa fa-thumbs-up"></i> Thích:
                                        <a href="javascript:void(0)" id="total_likeordislike" onclick="listUserLikeAndDislike(this)" data-type="like" data-articletype="<?php echo $object->type; ?>" data-id="<?php echo $object->_id; ?>"><?php echo $object->like; ?></a>
                                    </p>

                                    <p class="boutdislike"><i class="fa fa-thumbs-down"></i> Không
                                        thích: <a href="javascript:void(0)" id="total_likeordislike" onclick="listUserLikeAndDislike(this)" data-type="dislike" data-articletype="<?php echo $object->type; ?>" data-id="<?php echo $object->_id; ?>"><?php echo $object->dislike; ?></a>
                                    <p>
                                        <?php } else { ?>
                                    <p class="boutlike main-nav"><i class="fa fa-thumbs-up"></i> Thích:
                                        <a href="javascript:void(0)" id="total_likeordislike" class="cd-signin"><?php echo $object->like; ?> </a>
                                    </p>

                                    <p class="boutdislike main-nav"><i class="fa fa-thumbs-down"></i> Không
                                        thích: <a href="javascript:void(0)" id="total_likeordislike" class="cd-signin"><?php echo $object->dislike; ?> </a>
                                    <p>
                                        <?php } ?> 
                                    <p class="user"><i class="fa fa-user"></i> Người gửi:
                                        <a href="<?php echo $object->usercreatelink; ?>"
                                           style="<?php if ($object->is_role == 1) { ?> color: #c73030;<?php } else { ?> color: #176093;<?php } ?>"
                                           title="<?php echo $object->usercreate; ?>"><?php echo $object->usercreate; ?></a>
                                        <span class="role_user"><?php echo $object->usercreate_namerole; ?></span>
                                    </p>

                                    <p>
                                    <div class="fb-like" data-href="<?php echo $currentLink; ?>" data-layout="button_count"
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
                                                
                                                <li><a href="javascript:;" class="jp-shuffle-off" tabindex="1"
                                                       title="shuffle off" style="display: none;"></a></li>
                                                <li class="drop">
                                                    <a class="jp-click" href="javascript:void(0)"></a>

                                                    <div class="dropdownContain">
                                                        <div class="dropOut">
                                                            <div class="triangle"></div>
                                                            <ul>
                                                                <?php if ($object->media_link_320k) { ?>
                                                                    <li><a class="media_quality_select"
                                                                           href="javascript:;"
                                                                           data-media-src="<?php echo $object->media_link_320k; ?>"
                                                                           data-media-type="320">
                                                                            320K
                                                                        </a></li>
                                                                <?php } ?>
                                                                <?php if ($object->media_link_128k) { ?>
                                                                    <li><a class="media_quality_select"
                                                                           href="javascript:;"
                                                                           data-media-src="<?php echo $object->media_link_128k; ?>"
                                                                           data-media-type="128">
                                                                            128K
                                                                        </a></li>
                                                                <?php } ?>
                                                                <?php if ($object->media_link_64k) { ?>
                                                                    <li><a class="media_quality_select" style="color: #B302CB"
                                                                           href="javascript:;"
                                                                           data-media-src="<?php echo $object->media_link_64k; ?>"
                                                                           data-media-type="64">
                                                                            64K
                                                                        </a></li>
                                                                <?php } ?>
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
                        <input type="hidden" id="type" value="<?php echo $object->type; ?>"/>
                        <input type="hidden" id="url_article" value="<?php echo $currentLink; ?>"/>
                        <?php if ($session['_id']) { ?>
                            <ul class="media-func">
                                <li><i class="fa fa-plus"></i> <a href="javascript:void(0)"
                                                                  data-toggle="modal" data-target="#my-playlist-box" onclick='showFormAddPlaylist()'>Thêm vào</a>
                                </li>

                                <li><i class="fa fa-download"></i> <a href="javascript:void(0)" data-toggle="modal" data-target="#down-mp3">Tải
                                        về</a>
                                </li>
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
                                    <a href="javascript:void(0)" onclick="Nominations(<?php echo $object->_id; ?>);">Đề cử</a>
                                </li>
                                <li>
                                    <i class="fa fa-flag"></i> <a data-target="#sendfeedback" data-toggle="modal"
                                                                  href="javascript:void(0)">Báo lỗi</a>
                                </li>
                                
                                <li>
                                    <i class="fa fa-share-alt"></i>
                                    <a href="javascript:void(0)"  data-toggle="modal" data-target="#embed-share-popup">Chia sẻ</a>
                                    <!-- <a href="javascript:void(0)" onclick="share_facebook()">Chia sẻ</a> -->
                                </li>
                            </ul>
                        <?php } else { ?>
                            <ul class="media-func ">
                                <li class="main-nav"><i class="fa fa-plus"></i> <a class="cd-signin"
                                                                                   href="javascript:void(0)">Thêm vào
                                        playlist</a></li>
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
                                
                                <li>
                                    <i class="fa fa-share-alt"></i>
                                    <a href="javascript:void(0)"  data-toggle="modal" data-target="#embed-share-popup">Chia sẻ</a>
                                    <!-- <a href="javascript:void(0)" onclick="share_facebook()">Chia sẻ</a> -->
                                </li>
                            </ul>
                        <?php } ?>
                    </div>
                    <?php if ($listtags) { ?>
                        <div class="tags"><strong><i class="fa fa-tags"></i> Tags:</strong>
                            <?php $v12593744712802147721iterator = $listtags; $v12593744712802147721incr = 0; $v12593744712802147721loop = new stdClass(); $v12593744712802147721loop->length = count($v12593744712802147721iterator); $v12593744712802147721loop->index = 1; $v12593744712802147721loop->index0 = 1; $v12593744712802147721loop->revindex = $v12593744712802147721loop->length; $v12593744712802147721loop->revindex0 = $v12593744712802147721loop->length - 1; ?><?php foreach ($v12593744712802147721iterator as $item) { ?><?php $v12593744712802147721loop->first = ($v12593744712802147721incr == 0); $v12593744712802147721loop->index = $v12593744712802147721incr + 1; $v12593744712802147721loop->index0 = $v12593744712802147721incr; $v12593744712802147721loop->revindex = $v12593744712802147721loop->length - $v12593744712802147721incr; $v12593744712802147721loop->revindex0 = $v12593744712802147721loop->length - ($v12593744712802147721incr + 1); $v12593744712802147721loop->last = ($v12593744712802147721incr == ($v12593744712802147721loop->length - 1)); ?>
                                <a href="<?php echo $item['link']; ?>"><?php echo $item['name']; ?></a>
                            <?php $v12593744712802147721incr++; } ?>
                        </div>
                    <?php } ?>

                    <div style="min-height: 331px;" class="lyric">
                        <div class="pd_name_lyric">
                            <h2 class="name_lyric"><b>Lời bài hát: <?php echo $object->name; ?></b></h2>

                            <p class="name_post">Lời đăng bởi: <a title="<?php echo $object->usercreate; ?>"
                                                                  style="<?php if ($object->is_role == 1) { ?> color: #c73030;<?php } else { ?> color: #176093;<?php } ?>"
                                                                  href="<?php echo $object->usercreatelink; ?>"
                                                                  rel="nofollow"><?php echo $object->usercreate; ?></a></p>

                        </div>
                        <?php if ($object->content == '') { ?>
                            <p>No Tracklist!</p>
                        <?php } ?>
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
                            <?php echo $object->content; ?>
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
                            <?php $v12593744712802147721iterator = $listalbum; $v12593744712802147721incr = 0; $v12593744712802147721loop = new stdClass(); $v12593744712802147721loop->length = count($v12593744712802147721iterator); $v12593744712802147721loop->index = 1; $v12593744712802147721loop->index0 = 1; $v12593744712802147721loop->revindex = $v12593744712802147721loop->length; $v12593744712802147721loop->revindex0 = $v12593744712802147721loop->length - 1; ?><?php foreach ($v12593744712802147721iterator as $item) { ?><?php $v12593744712802147721loop->first = ($v12593744712802147721incr == 0); $v12593744712802147721loop->index = $v12593744712802147721incr + 1; $v12593744712802147721loop->index0 = $v12593744712802147721incr; $v12593744712802147721loop->revindex = $v12593744712802147721loop->length - $v12593744712802147721incr; $v12593744712802147721loop->revindex0 = $v12593744712802147721loop->length - ($v12593744712802147721incr + 1); $v12593744712802147721loop->last = ($v12593744712802147721incr == ($v12593744712802147721loop->length - 1)); ?>
                                <div class="block-music mr10">
                                    <div class="cover-outer-align">
                                        <a href="<?php echo $item['link']; ?>">
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
    <?php $v12593744712802147721iterator = $item['listartist']; $v12593744712802147721incr = 0; $v12593744712802147721loop = new stdClass(); $v12593744712802147721loop->length = count($v12593744712802147721iterator); $v12593744712802147721loop->index = 1; $v12593744712802147721loop->index0 = 1; $v12593744712802147721loop->revindex = $v12593744712802147721loop->length; $v12593744712802147721loop->revindex0 = $v12593744712802147721loop->length - 1; ?><?php foreach ($v12593744712802147721iterator as $itemchild) { ?><?php $v12593744712802147721loop->first = ($v12593744712802147721incr == 0); $v12593744712802147721loop->index = $v12593744712802147721incr + 1; $v12593744712802147721loop->index0 = $v12593744712802147721incr; $v12593744712802147721loop->revindex = $v12593744712802147721loop->length - $v12593744712802147721incr; $v12593744712802147721loop->revindex0 = $v12593744712802147721loop->length - ($v12593744712802147721incr + 1); $v12593744712802147721loop->last = ($v12593744712802147721incr == ($v12593744712802147721loop->length - 1)); ?>
    <a class="subtitle" href="<?php echo $itemchild['link']; ?>"
       title="<?php echo $itemchild['username']; ?>"><?php echo $itemchild['username']; ?></a><?php if (!$v12593744712802147721loop->last) { ?><span class="bull" style="font-size:12px;">Ft </span><?php } ?>
    <?php $v12593744712802147721incr++; } ?>
    <span class="paragraph-end"></span>
    <?php } ?>
</div>
                                    </div>
                                </div>
                            <?php $v12593744712802147721incr++; } ?>
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
                            <?php $v12593744712802147721iterator = $listmusicbyview; $v12593744712802147721incr = 0; $v12593744712802147721loop = new stdClass(); $v12593744712802147721loop->length = count($v12593744712802147721iterator); $v12593744712802147721loop->index = 1; $v12593744712802147721loop->index0 = 1; $v12593744712802147721loop->revindex = $v12593744712802147721loop->length; $v12593744712802147721loop->revindex0 = $v12593744712802147721loop->length - 1; ?><?php foreach ($v12593744712802147721iterator as $item) { ?><?php $v12593744712802147721loop->first = ($v12593744712802147721incr == 0); $v12593744712802147721loop->index = $v12593744712802147721incr + 1; $v12593744712802147721loop->index0 = $v12593744712802147721incr; $v12593744712802147721loop->revindex = $v12593744712802147721loop->length - $v12593744712802147721incr; $v12593744712802147721loop->revindex0 = $v12593744712802147721loop->length - ($v12593744712802147721incr + 1); $v12593744712802147721loop->last = ($v12593744712802147721incr == ($v12593744712802147721loop->length - 1)); ?>
                            <li><a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>" class="thumb pull-left">
                                    <img src="<?php echo $item['priavatar']; ?>" alt="<?php echo $item['name']; ?>">
                                </a>

                                <h3 class="song-name"><a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>"
                                                         class="txt-primary"><?php echo $item['name']; ?></a>
                                </h3>

                                <div class="singer-name">
                                    <?php $v12593744712802147722iterator = $item['artist']; $v12593744712802147722incr = 0; $v12593744712802147722loop = new stdClass(); $v12593744712802147722loop->length = count($v12593744712802147722iterator); $v12593744712802147722loop->index = 1; $v12593744712802147722loop->index0 = 1; $v12593744712802147722loop->revindex = $v12593744712802147722loop->length; $v12593744712802147722loop->revindex0 = $v12593744712802147722loop->length - 1; ?><?php foreach ($v12593744712802147722iterator as $artist) { ?><?php $v12593744712802147722loop->first = ($v12593744712802147722incr == 0); $v12593744712802147722loop->index = $v12593744712802147722incr + 1; $v12593744712802147722loop->index0 = $v12593744712802147722incr; $v12593744712802147722loop->revindex = $v12593744712802147722loop->length - $v12593744712802147722incr; $v12593744712802147722loop->revindex0 = $v12593744712802147722loop->length - ($v12593744712802147722incr + 1); $v12593744712802147722loop->last = ($v12593744712802147722incr == ($v12593744712802147722loop->length - 1)); ?>
                                    <a href="<?php echo $artist['link']; ?>"
                                       title="<?php echo $artist['username']; ?>"><?php echo $artist['username']; ?></a><?php if (!$v12593744712802147722loop->last) { ?><span>Ft</span><?php } ?>
                                    <?php $v12593744712802147722incr++; } ?>
                                </div>

                            </li>
                            <?php $v12593744712802147721incr++; } ?>
                        </ul>

                    </div>
                    <div class="sidebar">
                        <h2 class="heading">Có thể bạn muốn nghe</h2>

                        <div class="main-boder">
                            <div data-special-type="app" class="player-container2">
                                <div data-special-type="app" class="player-container2">
                                    <ul class="listtop">

                                        <?php $v12593744712802147721iterator = $listMusic; $v12593744712802147721incr = 0; $v12593744712802147721loop = new stdClass(); $v12593744712802147721loop->length = count($v12593744712802147721iterator); $v12593744712802147721loop->index = 1; $v12593744712802147721loop->index0 = 1; $v12593744712802147721loop->revindex = $v12593744712802147721loop->length; $v12593744712802147721loop->revindex0 = $v12593744712802147721loop->length - 1; ?><?php foreach ($v12593744712802147721iterator as $key => $item) { ?><?php $v12593744712802147721loop->first = ($v12593744712802147721incr == 0); $v12593744712802147721loop->index = $v12593744712802147721incr + 1; $v12593744712802147721loop->index0 = $v12593744712802147721incr; $v12593744712802147721loop->revindex = $v12593744712802147721loop->length - $v12593744712802147721incr; $v12593744712802147721loop->revindex0 = $v12593744712802147721loop->length - ($v12593744712802147721incr + 1); $v12593744712802147721loop->last = ($v12593744712802147721incr == ($v12593744712802147721loop->length - 1)); ?>
                                            <?php $cl = 'special-4'; ?>
                                            <?php if ($key == 0) { ?> <?php $cl = 'special-1'; ?> <?php } ?>
                                            <?php if ($key == 1) { ?> <?php $cl = 'special-2'; ?> <?php } ?>
                                            <?php if ($key == 2) { ?> <?php $cl = 'special-3'; ?> <?php } ?>
                                            <li><a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>"><span
                                                            class="number <?php echo $cl; ?>"><?php echo $key + 1; ?></span><?php echo $item['name']; ?>
                                                </a></li>
                                        <?php $v12593744712802147721incr++; } ?>
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
            <?php $v12593744712802147721iterator = $listCategory_footer; $v12593744712802147721incr = 0; $v12593744712802147721loop = new stdClass(); $v12593744712802147721loop->length = count($v12593744712802147721iterator); $v12593744712802147721loop->index = 1; $v12593744712802147721loop->index0 = 1; $v12593744712802147721loop->revindex = $v12593744712802147721loop->length; $v12593744712802147721loop->revindex0 = $v12593744712802147721loop->length - 1; ?><?php foreach ($v12593744712802147721iterator as $item) { ?><?php $v12593744712802147721loop->first = ($v12593744712802147721incr == 0); $v12593744712802147721loop->index = $v12593744712802147721incr + 1; $v12593744712802147721loop->index0 = $v12593744712802147721incr; $v12593744712802147721loop->revindex = $v12593744712802147721loop->length - $v12593744712802147721incr; $v12593744712802147721loop->revindex0 = $v12593744712802147721loop->length - ($v12593744712802147721incr + 1); $v12593744712802147721loop->last = ($v12593744712802147721incr == ($v12593744712802147721loop->length - 1)); ?>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="list1">
                        <li style="font-weight: bold;;"><a href="<?php echo $item['link']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>"><?php echo $item['title']; ?></a></li>
                        <?php if (isset($item['child'])) { ?>
                            <?php $v12593744712802147722iterator = $item['child']; $v12593744712802147722incr = 0; $v12593744712802147722loop = new stdClass(); $v12593744712802147722loop->length = count($v12593744712802147722iterator); $v12593744712802147722loop->index = 1; $v12593744712802147722loop->index0 = 1; $v12593744712802147722loop->revindex = $v12593744712802147722loop->length; $v12593744712802147722loop->revindex0 = $v12593744712802147722loop->length - 1; ?><?php foreach ($v12593744712802147722iterator as $child) { ?><?php $v12593744712802147722loop->first = ($v12593744712802147722incr == 0); $v12593744712802147722loop->index = $v12593744712802147722incr + 1; $v12593744712802147722loop->index0 = $v12593744712802147722incr; $v12593744712802147722loop->revindex = $v12593744712802147722loop->length - $v12593744712802147722incr; $v12593744712802147722loop->revindex0 = $v12593744712802147722loop->length - ($v12593744712802147722incr + 1); $v12593744712802147722loop->last = ($v12593744712802147722incr == ($v12593744712802147722loop->length - 1)); ?>
                                <li><a href="<?php echo $child['link']; ?>" alt="<?php echo $child['title']; ?>" title="<?php echo $child['title']; ?>"><?php echo $child['title']; ?></a></li>
                            <?php $v12593744712802147722incr++; } ?>
                        <?php } ?>
                    </ul>
                </div>
            <?php $v12593744712802147721incr++; } ?>
            <div class="col-md-2 col-sm-3 col-xs-6">
                <ul class="list1">
                    <li><a href="/dieu-khoan-thoa-thuan.html">Điều khoản thảo thuận</a></li>
                    <li><a href="/chinh-sach-rieng-tu.html">Chính sách riêng tư</a></li>
                    <li><a href="/chinh-sach-ban-quyen.html">Chính sách bản quyền</a></li>
                    <li><a href="/lien-he.html">Liên hệ</a></li>
                    <li><a href="#">Quảng cáo</a></li>
                </ul>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="share">
                    <h2>Share online</h2>
                    <ul class="social">
                        <li><a rel="nofollow" class="tooltip-top" title="Share Facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a rel="nofollow" class="tooltip-top" title="Share Google +" href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a rel="nofollow" class="tooltip-top" title="Share Twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a rel="nofollow" class="tooltip-top" title="Share Instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
</footer>



<!-- form-chia-se-popup -->	
<div class="modal fade" id="embed-share-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-link"></i> Chia sẻ link</h4>
          </div>
          <div class="modal-body">
           
				<form class="cd-form"> 

					<p class="fieldset">
						<i class="fa fa-link"></i>
						<input class="full-width has-padding has-border" type="text"  value="<?php echo $currentLink; ?>" id='share-popup-full'>  
					</p>
					
					<?php if (empty($not_link_embed)) { ?>
					<p class="fieldset">
                        <i class="fa fa-file-code-o"></i>
						<input class="full-width has-padding has-border" type="text" id='share-popup-iframe' value="<iframe src=&quot;<?php echo $iframe_share_link; ?>&quot; width=&quot;316&quot; height=&quot;587&quot; frameborder=&quot;0&quot; allowfullscreen></iframe>">
					</p>
					<?php } ?>
          
					<p class="fieldset">
						<input class="full-width has-padding" type="submit" value="Chia sẻ">
					</p>
				</form>

          </div>
      </div>
   </div>
</div>
<script type="text/javascript">
	$(function() {
		$('#share-popup-full, #share-popup-iframe').on('click', function(){
			$(this).select();
		})
	});
</script>


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
                        <input class="full-width has-padding" type="submit" value="Gửi" data-id="<?php echo $object->_id; ?>"
                               data-type="<?php echo $object->type; ?>" onclick="sendfeedback(this)">
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
                                <p>Click vào 1 trong các liên kết bên dưới để Download về máy Bài hát: <strong><?php echo $object->name; ?></strong></p>
                                <?php if ($object->media_link_320k) { ?>
                                    <li><a href="javascript:void(0)" title="#" onclick="downloadMedia(this)" data-id="<?php echo $object->_id; ?>" data-quality="media_link_320k">320k</a></li>
                                <?php } ?>
                                <?php if ($object->media_link_128k) { ?>
                                    <li><a href="javascript:void(0)" title="#" onclick="downloadMedia(this)" data-id="<?php echo $object->_id; ?>" data-quality="media_link_128k">128k</a></li>
                                <?php } ?>
                                <?php if ($object->media_link_64k) { ?>
                                    <li><a href="javascript:void(0)" title="#" onclick="downloadMedia(this)" data-id="<?php echo $object->_id; ?>" data-quality="media_link_64k">64k</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--End-->

<input type="hidden" id="add-playlist-atid" value="<?php echo $object->_id; ?>">

<!-- form-add-playlist -->
<div class="modal fade" id="my-playlist-box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Chọn playlist muốn thêm</h4>
            </div>
            <div class="modal-body">

                <ul class="m-add-playlist">
                    <div style="height:150px">
                        <div class="nano">
                            <div class="content list-playlist-item">
                            </div>
                        </div>
                    </div>
                </ul>

                <div class="col-add-plt">
                    <form method="post" action="">
                        <div class="col-md-9 col-sm-9 col-xs-8"><input class="ip-ptl" type="text" name="playlist_name" id="add-playlist-name" placeholder="--- Thêm playlist mới ---"></div>
                        <div class="col-md-3 col-sm-3 col-xs-4"><a class="btn-plt" onclick="addNewPlaylist()" id="add-new-playlist-btn" href="javascript:void(0);">Thêm</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- form add playlist -->
<!-- <div style="display: none;" id="my-playlist-box">
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
</div> -->
<script>
    function showFormAddPlaylist(atid) {
        if (typeof atid != 'undefined') {
            $("#add-playlist-atid").val(atid);
        }
        $('.list-playlist-item').empty()
                .append('<li style="text-align:center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></li>');

        $.get("/incoming/getallplaylist", {}, function (re) {
            var data = re.data;
            var html = '';
            $('.list-playlist-item').empty();
            if (data != null) {
                jQuery.each(data, function (index, value) {
                    html += '<li>'
                            + '<span><i class="fa fa-music"></i><a  onclick="addSoongToPlaylist(' + value._id + ')" href="javascript:void(0);">' + value.name + '</a></span>'
                    '</li>';
                });
                $('.list-playlist-item').append(html);
            } else {
                alert('Bạn chưa có playlist nào.');
            }
        });

    }
    function closeAddPlaylist() {
        $('#my-playlist-box').css('display', 'none');
    }
    function addNewPlaylist() {
        var name = $('#add-playlist-name').val();
        $.get("/incoming/addplaylist", {name: name}, function (re) {
            console.log(re);
            var result = re.data;
            var html = '';
            if (re.status == 200) {
                html += '<li>'
                        + '<span><i class="fa fa-music"></i><a  onclick="addSoongToPlaylist(' + result._id + ')" href="javascript:void(0);">' + result.name + '</a></span>'
                '</li>';
                $('.list-playlist-item').append(html);
                alert('Thêm mới Playlist thành công!');
            }
            else {
                alert(re.mss);
            }
        });
    }
    function addSoongToPlaylist(plid) {
        var atid = $('#add-playlist-atid').val();
        $.get("/incoming/addsoongtoplaylist", {pllid: plid, atid: atid}, function (re) {
            if (re.status == 200) {
                alert('Thêm nhạc vào playlist thành công!');
            }
            else {
                alert(re.mss);
            }
        });
    }
</script>


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
        if (p >= totalpage) $('#viewmore').hide();

    }
</script>
