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
                                                            <?php $v92549103778162467062iterator = $item['child']; $v92549103778162467062incr = 0; $v92549103778162467062loop = new stdClass(); $v92549103778162467062loop->length = count($v92549103778162467062iterator); $v92549103778162467062loop->index = 1; $v92549103778162467062loop->index0 = 1; $v92549103778162467062loop->revindex = $v92549103778162467062loop->length; $v92549103778162467062loop->revindex0 = $v92549103778162467062loop->length - 1; ?><?php foreach ($v92549103778162467062iterator as $indexItemChild => $itemchild) { ?><?php $v92549103778162467062loop->first = ($v92549103778162467062incr == 0); $v92549103778162467062loop->index = $v92549103778162467062incr + 1; $v92549103778162467062loop->index0 = $v92549103778162467062incr; $v92549103778162467062loop->revindex = $v92549103778162467062loop->length - $v92549103778162467062incr; $v92549103778162467062loop->revindex0 = $v92549103778162467062loop->length - ($v92549103778162467062incr + 1); $v92549103778162467062loop->last = ($v92549103778162467062incr == ($v92549103778162467062loop->length - 1)); ?>
                                                                <?php if ($indexItemChild % 6 == 0) { ?>
                                                                    <div class="<?php echo $cssColumn; ?> col-xs-12">
                                                                    <div class="bvmenu">
                                                                <?php } ?>
                                                                <a href="<?php echo $itemchild['link']; ?>"><?php echo $itemchild['title']; ?></a>
                                                                <?php if ($indexItemChild % 6 == 5 || $v92549103778162467062loop->last) { ?>
                                                                    </div>
                                                                    </div>
                                                                <?php } ?>
                                                            <?php $v92549103778162467062incr++; } ?>
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
    <div class="bg-cmvideo">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/trang-chu.html"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/video.html">Video</a></li>
                <?php foreach ($listCategory as $item) { ?>
                    <li><a href="<?php echo $item['link']; ?>"><?php echo $item['name']; ?></a></li>
                <?php } ?>
            </ul>
        </div>

        <div class="container">
            <div class="row">
                <article class="col-ldh-9 col-sm-8">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="info-video-top">
                                <h2><?php echo $object->name; ?>
                                    <?php if ($listartist) { ?>
                                    <span class="bull">-</span>
                                    <?php $v16896070505752363301iterator = $listartist; $v16896070505752363301incr = 0; $v16896070505752363301loop = new stdClass(); $v16896070505752363301loop->length = count($v16896070505752363301iterator); $v16896070505752363301loop->index = 1; $v16896070505752363301loop->index0 = 1; $v16896070505752363301loop->revindex = $v16896070505752363301loop->length; $v16896070505752363301loop->revindex0 = $v16896070505752363301loop->length - 1; ?><?php foreach ($v16896070505752363301iterator as $item) { ?><?php $v16896070505752363301loop->first = ($v16896070505752363301incr == 0); $v16896070505752363301loop->index = $v16896070505752363301incr + 1; $v16896070505752363301loop->index0 = $v16896070505752363301incr; $v16896070505752363301loop->revindex = $v16896070505752363301loop->length - $v16896070505752363301incr; $v16896070505752363301loop->revindex0 = $v16896070505752363301loop->length - ($v16896070505752363301incr + 1); $v16896070505752363301loop->last = ($v16896070505752363301incr == ($v16896070505752363301loop->length - 1)); ?>
                                    <a href="<?php echo $item['link']; ?>"
                                       title="<?php echo $item['username']; ?>"><?php echo $item['username']; ?></a>
                                    <span class="bull"><?php if (!$v16896070505752363301loop->last) { ?>Ft <?php } ?></span>
                                    <?php $v16896070505752363301incr++; } ?>
                                    <?php } ?>
                                </h2>

                                <div class="info-pd-top">
                                    <p>
                                        <i class="fa fa-youtube-play"></i> Lượt xem: <?php echo $object->view; ?>
                                        <span class="boutlike" style="color: white;">
                                            <i class="fa fa-thumbs-up"></i> Thích: <?php echo $object->like; ?>
                                        </span>
                                        <span class="boutdislike" style="color: white;">
                                            <i class="fa fa-thumbs-down"></i> Không thích: <?php echo $object->dislike; ?>
                                        </span>
                                         <span class="boutdislike" style="color: white;">
                                            <i class="fa fa-user"></i> Người gửi:
                                             
                                             <a href="<?php echo $object->usercreatelink; ?>"
                                                style="<?php if ($object->is_role == 1) { ?> color: #c73030;<?php } else { ?> color: #176093;<?php } ?>"
                                                title="<?php echo $object->usercreate; ?>"><?php echo $object->usercreate; ?></a>
                                        <span class="role_user"><?php echo $object->usercreate_namerole; ?></span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php if ($checklink) { ?>
                        <video id="videodj" poster="<?php echo $object->priavatar; ?>" class="video-js vjs-default-skin"
                               width="100%" height="472" loop
                               controls preload="auto" autoplay
                               data-setup='{"techOrder": ["youtube"],"src": "<?php echo $object->mediaurl; ?>" }'>
                            <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to
                                a
                                web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports
                                    HTML5 video</a></p>
                        </video>
                    <?php } else { ?>
                        <video id="videodj" poster="<?php echo $object->priavatar; ?>"
                               class="video-js vjs-default-skin vjs-resolution-button-label vjs-resolution-button"
                               height="472" loop
                               controls preload="auto" autoplay
                               data-setup='{}'
                        >
                            <?php if ($object->link_video_360) { ?>
                                <?php $media_url = $object->link_video_360; ?>
                            <?php } else { ?>
                                <?php $media_url = $object->direct_media_url; ?>
                            <?php } ?>
                            <source src="<?php echo $media_url; ?>" type='video/mp4' label="Default"/>
                            <?php if ($object->link_video_1080) { ?>
                                <source src="<?php echo $object->link_video_1080; ?>" type='video/mp4' label='1080p'/>
                            <?php } ?>
                            <?php if ($object->link_video_720) { ?>
                                <source src="<?php echo $object->link_video_720; ?>" type='video/mp4' label='720p'/>
                            <?php } ?>
                            <?php if ($object->link_video_480) { ?>
                                <source src="<?php echo $object->link_video_480; ?>" type='video/mp4' label='480p'/>
                            <?php } ?>
                            <?php if ($object->link_video_360) { ?>
                                <source src="<?php echo $object->link_video_360; ?>" type='video/mp4' label='360p'/>
                            <?php } ?>

                            <?php if ($object->link_video_240) { ?>
                                <source src="<?php echo $object->link_video_240; ?>" type='video/mp4' label='240p'/>
                            <?php } ?>

                            <?php if ($object->link_video_144) { ?>
                                <source src="<?php echo $object->link_video_144; ?>" type='video/mp4' label='144p'/>
                            <?php } ?>

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
                    <?php } ?>
                    <!--End-video-->
                    <div class="row col-md-12">
                        <input type="hidden" id="type" value="<?php echo $object->type; ?>"/>
                        <input type="hidden" id="url_article" value="<?php echo $currentLink; ?>"/>

                        <?php if ($session['_id']) { ?>
                            <ul class="media-func">
                                <li><i class="fa fa-plus"></i> <a href="javascript:void(0)"
                                                                  onclick="showFormAddPlaylist();">Thêm vào</a>
                                </li>
                                </li>
                                <li>
                                    <i class="fa fa-thumbs-up"
                                       id="icon-like" <?php if ($check_like->_id) { ?> style="color: blue;" <?php } ?>></i>
                                    <a href="javascript:void(0)" onclick="likeArticle(this);"
                                       data-id="<?php echo $object->_id; ?>"
                                       checklike="<?php echo ($check_like->_id > 0 ? 1 : 0); ?>">Thích</a>
                                </li>
                                <li>
                                    <i class="fa fa-thumbs-down"
                                       id="icon-dislike" <?php if ($check_dislike->_id) { ?> style="color: blue;" <?php } ?>></i>
                                    <a href="javascript:void(0)" onclick="dislikeArticle(this);"
                                       data-id="<?php echo $object->_id; ?>" checklike="<?php echo ($check_dislike->_id > 0 ? 1 : 0); ?>">Không
                                        thích</a>
                                </li>
                                <li><i class="fa fa-star"
                                       id="icon-nominations" <?php if ($check_nominations->_id) { ?> style="color: blue;" <?php } ?>></i>
                                    <a href="javascript:void(0)" onclick="Nominations(<?php echo $object->_id; ?>);">Đề cử</a>
                                </li>
                                <li>
                                    <i class="fa fa-flag"></i> <a data-target="#sendfeedback" data-toggle="modal"
                                                                  href="javascript:void(0)">Báo lỗi</a>
                                </li>
                                
                                <li><i class="fa fa-share-alt"></i> <a href="javascript:void(0)"
                                                                       onclick="share_facebook()">Chia sẻ</a></li>
                            </ul>
                        <?php } else { ?>
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
                                
                                <li><i class="fa fa-share-alt"></i> <a href="javascript:void(0)"
                                                                       onclick="share_facebook()">Chia sẻ</a></li>
                            </ul>
                        <?php } ?>
                    </div>
                    <?php if ($listtags) { ?>
                        <div class="tags" style="color: white;"><strong><i class="fa fa-tags"></i> Tags:</strong>
                            <?php $v16896070505752363301iterator = $listtags; $v16896070505752363301incr = 0; $v16896070505752363301loop = new stdClass(); $v16896070505752363301loop->length = count($v16896070505752363301iterator); $v16896070505752363301loop->index = 1; $v16896070505752363301loop->index0 = 1; $v16896070505752363301loop->revindex = $v16896070505752363301loop->length; $v16896070505752363301loop->revindex0 = $v16896070505752363301loop->length - 1; ?><?php foreach ($v16896070505752363301iterator as $item) { ?><?php $v16896070505752363301loop->first = ($v16896070505752363301incr == 0); $v16896070505752363301loop->index = $v16896070505752363301incr + 1; $v16896070505752363301loop->index0 = $v16896070505752363301incr; $v16896070505752363301loop->revindex = $v16896070505752363301loop->length - $v16896070505752363301incr; $v16896070505752363301loop->revindex0 = $v16896070505752363301loop->length - ($v16896070505752363301incr + 1); $v16896070505752363301loop->last = ($v16896070505752363301incr == ($v16896070505752363301loop->length - 1)); ?>
                                <a href="<?php echo $item['link']; ?>"><?php echo $item['name']; ?></a>
                            <?php $v16896070505752363301incr++; } ?>
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
                            <?php $v16896070505752363301iterator = $listVideo; $v16896070505752363301incr = 0; $v16896070505752363301loop = new stdClass(); $v16896070505752363301loop->length = count($v16896070505752363301iterator); $v16896070505752363301loop->index = 1; $v16896070505752363301loop->index0 = 1; $v16896070505752363301loop->revindex = $v16896070505752363301loop->length; $v16896070505752363301loop->revindex0 = $v16896070505752363301loop->length - 1; ?><?php foreach ($v16896070505752363301iterator as $item) { ?><?php $v16896070505752363301loop->first = ($v16896070505752363301incr == 0); $v16896070505752363301loop->index = $v16896070505752363301incr + 1; $v16896070505752363301loop->index0 = $v16896070505752363301incr; $v16896070505752363301loop->revindex = $v16896070505752363301loop->length - $v16896070505752363301incr; $v16896070505752363301loop->revindex0 = $v16896070505752363301loop->length - ($v16896070505752363301incr + 1); $v16896070505752363301loop->last = ($v16896070505752363301incr == ($v16896070505752363301loop->length - 1)); ?>
                                <div class="block-music mr10">
                                    <div class="cover-outer-align">
                                        <a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>">
                                            <img class="img-responsive" src="<?php echo $item['priavatar']; ?>"
                                                 alt="<?php echo $item['link']; ?>"/>
                                        </a>
                                           <span class="icon-circle-play">
                                               <a class="button" href="<?php echo $item['link']; ?>" title=""><i
                                                           class="fa fa-play"></i></a>
                                           </span>
                                        <a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>">
                                            <div class="video-item-info">
                                            <span class="video-item-view"><span
                                                        class="fa fa-eye"></span> <?php echo $item['view']; ?></span>
                                            <span class="video-item-like"><span
                                                        class="fa fa-clock-o"></span> <?php echo $item['duration']; ?></span>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="details">
                                        <h3><a href="<?php echo $item['link']; ?>" class="title tooltip-top"
                                               title="<?php echo $item['name']; ?>"><?php echo $item['name']; ?>
                                                <span class="paragraph-end"></span></a></h3>

                                        <div class="hide-ns">
    <?php if ($item['listartist']) { ?>
    <?php $v16896070505752363301iterator = $item['listartist']; $v16896070505752363301incr = 0; $v16896070505752363301loop = new stdClass(); $v16896070505752363301loop->length = count($v16896070505752363301iterator); $v16896070505752363301loop->index = 1; $v16896070505752363301loop->index0 = 1; $v16896070505752363301loop->revindex = $v16896070505752363301loop->length; $v16896070505752363301loop->revindex0 = $v16896070505752363301loop->length - 1; ?><?php foreach ($v16896070505752363301iterator as $itemchild) { ?><?php $v16896070505752363301loop->first = ($v16896070505752363301incr == 0); $v16896070505752363301loop->index = $v16896070505752363301incr + 1; $v16896070505752363301loop->index0 = $v16896070505752363301incr; $v16896070505752363301loop->revindex = $v16896070505752363301loop->length - $v16896070505752363301incr; $v16896070505752363301loop->revindex0 = $v16896070505752363301loop->length - ($v16896070505752363301incr + 1); $v16896070505752363301loop->last = ($v16896070505752363301incr == ($v16896070505752363301loop->length - 1)); ?>
    <a class="subtitle" href="<?php echo $itemchild['link']; ?>"
       title="<?php echo $itemchild['username']; ?>"><?php echo $itemchild['username']; ?></a><?php if (!$v16896070505752363301loop->last) { ?><span class="bull" style="font-size:12px;">Ft </span><?php } ?>
    <?php $v16896070505752363301incr++; } ?>
    <span class="paragraph-end"></span>
    <?php } ?>
</div>
                                    </div>
                                </div>
                            <?php $v16896070505752363301incr++; } ?>
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
                            <?php $v16896070505752363301iterator = $listvideobyview; $v16896070505752363301incr = 0; $v16896070505752363301loop = new stdClass(); $v16896070505752363301loop->length = count($v16896070505752363301iterator); $v16896070505752363301loop->index = 1; $v16896070505752363301loop->index0 = 1; $v16896070505752363301loop->revindex = $v16896070505752363301loop->length; $v16896070505752363301loop->revindex0 = $v16896070505752363301loop->length - 1; ?><?php foreach ($v16896070505752363301iterator as $item) { ?><?php $v16896070505752363301loop->first = ($v16896070505752363301incr == 0); $v16896070505752363301loop->index = $v16896070505752363301incr + 1; $v16896070505752363301loop->index0 = $v16896070505752363301incr; $v16896070505752363301loop->revindex = $v16896070505752363301loop->length - $v16896070505752363301incr; $v16896070505752363301loop->revindex0 = $v16896070505752363301loop->length - ($v16896070505752363301incr + 1); $v16896070505752363301loop->last = ($v16896070505752363301incr == ($v16896070505752363301loop->length - 1)); ?>
                            <li><a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>" class="thumb-vd pull-left">
                                    <img src="<?php echo $item['priavatar']; ?>" class="avatar_video" alt="<?php echo $item['name']; ?>">
                                </a>

                                <h3 class="song-name"><a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>"
                                                         class="txt-primary"><?php echo $item['name']; ?></a>
                                </h3>

                                <div class="singer-name">
                                    <?php $v16896070505752363302iterator = $item['artist']; $v16896070505752363302incr = 0; $v16896070505752363302loop = new stdClass(); $v16896070505752363302loop->length = count($v16896070505752363302iterator); $v16896070505752363302loop->index = 1; $v16896070505752363302loop->index0 = 1; $v16896070505752363302loop->revindex = $v16896070505752363302loop->length; $v16896070505752363302loop->revindex0 = $v16896070505752363302loop->length - 1; ?><?php foreach ($v16896070505752363302iterator as $artist) { ?><?php $v16896070505752363302loop->first = ($v16896070505752363302incr == 0); $v16896070505752363302loop->index = $v16896070505752363302incr + 1; $v16896070505752363302loop->index0 = $v16896070505752363302incr; $v16896070505752363302loop->revindex = $v16896070505752363302loop->length - $v16896070505752363302incr; $v16896070505752363302loop->revindex0 = $v16896070505752363302loop->length - ($v16896070505752363302incr + 1); $v16896070505752363302loop->last = ($v16896070505752363302incr == ($v16896070505752363302loop->length - 1)); ?>
                                    <a href="<?php echo $artist['link']; ?>"
                                       title="<?php echo $artist['username']; ?>"><?php echo $artist['username']; ?></a><?php if (!$v16896070505752363302loop->last) { ?><span>Ft</span><?php } ?>
                                    <?php $v16896070505752363302incr++; } ?>
                                </div>

                            </li>
                            <?php $v16896070505752363301incr++; } ?>
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

<footer>
    <div class="container">
        <div class="row">
            <?php $v16896070505752363301iterator = $listCategory_footer; $v16896070505752363301incr = 0; $v16896070505752363301loop = new stdClass(); $v16896070505752363301loop->length = count($v16896070505752363301iterator); $v16896070505752363301loop->index = 1; $v16896070505752363301loop->index0 = 1; $v16896070505752363301loop->revindex = $v16896070505752363301loop->length; $v16896070505752363301loop->revindex0 = $v16896070505752363301loop->length - 1; ?><?php foreach ($v16896070505752363301iterator as $index => $itemFooterMenu) { ?><?php $v16896070505752363301loop->first = ($v16896070505752363301incr == 0); $v16896070505752363301loop->index = $v16896070505752363301incr + 1; $v16896070505752363301loop->index0 = $v16896070505752363301incr; $v16896070505752363301loop->revindex = $v16896070505752363301loop->length - $v16896070505752363301incr; $v16896070505752363301loop->revindex0 = $v16896070505752363301loop->length - ($v16896070505752363301incr + 1); $v16896070505752363301loop->last = ($v16896070505752363301incr == ($v16896070505752363301loop->length - 1)); ?>
                <?php if ($index % 5 == 0) { ?>
                    <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="list1">
                <?php } ?>
                <li><a href="<?php echo $itemFooterMenu['link']; ?>"><?php echo $itemFooterMenu['title']; ?></a></li>
                <?php if ($index % 5 == 4 || $v16896070505752363301loop->last) { ?>
                    </ul>
                    </div>
                <?php } ?>
            <?php $v16896070505752363301incr++; } ?>

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
<input type="hidden" id="atid" value="<?php echo $object->_id; ?>">
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
        <?php if ($object->link_video_360) { ?>
        //set selected quality default is 360p
        $('li.vjs-menu-item').attr('class', 'vjs-menu-item');
        $('li.vjs-menu-item:contains("360p")').attr('class', 'vjs-menu-item vjs-selected');
        <?php } ?>
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
</script>
