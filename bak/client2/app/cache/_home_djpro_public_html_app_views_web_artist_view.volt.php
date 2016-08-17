

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

    <div class="banner-gs">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/trang-chu.html"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/nghe-sy.html">Nghệ sỹ</a></li>
                <?php foreach ($listcategory as $item) { ?>
                <li><a href="<?php echo $item['link']; ?>"><?php echo $item['name']; ?></a></li>
                <?php } ?>
                <li><a href="<?php echo $object->link; ?>"><?php echo $object->username; ?></a></li>
            </ul>
        </div>
        <div class="container">
            <div class="divpre">
                <img height="350" src="<?php echo $object->banner; ?>" alt="<?php echo $object->username; ?>">

                <div class="box-info-artist">
                    <div class="info-artist fluid">

                        <img height="150" src="<?php echo $object->priavatar; ?>" alt="<?php echo $object->username; ?>">

                        <div class="info-summary">
                            <div class="info-summary-title"><a href="<?php echo $object->link; ?>" title="<?php echo $object->username; ?>" alt="<?php echo $object->username; ?>"><h1><?php echo $object->username; ?></h1></a> </div>
                            <?php if ($object->description) { ?>
                                <p><?php echo $object->description; ?> <a href="<?php echo $object->link; ?>?t=info" >Tiểu sử <?php echo $object->username; ?></a></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="artists">
        <div class="container">
            <div class="row">

                <div class="col-ldh-9 col-sm-8">

                    <div class="tabs tabs-style-iconbox">
                        <nav>
                            <ul>
                                <li class="tabs_artist tab-current"><a href="<?php echo $object->link; ?>"
                                                                       class="icon icon-all"><span>Tất cả</span></a>
                                </li>
                                <li class="tabs_artist"><a href="<?php echo $object->link; ?>?t=audio" class="icon icon-baihat"><span>Bài hát đã đăng</span></a>
                                </li>
                                <li class="tabs_artist"><a href="<?php echo $object->link; ?>?t=album"
                                                           class="icon icon-album"><span>Album đã đăng</span></a></li>
                                <li class="tabs_artist"><a href="<?php echo $object->link; ?>?t=video"
                                                           class="icon icon-video"><span>Video đã đăng</span></a></li>
                                <li class="tabs_artist" id="story"><a class="icon icon-tieusu" href="<?php echo $object->link; ?>?t=info"><span>Tiểu sử</span></a>
                                </li>
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-linemove-1" class="content-current">
                                <div class="td_heading"><h2><span class="while"><a href="<?php echo $object->link; ?>?t=audio">Bài hát</a> (<span id="clkeyword"><?php echo $countaudio; ?></span>)<i class="fa fa-angle-right"></i></span>
                                    </h2></div>

                                <?php if ($listmedia) { ?>
                                    <div data-special-type="app">
                                        <ul class="listtop">
                                            <?php foreach ($listmedia as $key => $item) { ?>
                                                <li><a href="<?php echo $item['link']; ?>"><span><?php echo $key + 1; ?>. </span><span
                                                                class="song-title"><?php echo $item['name']; ?></span></a>

                                                    <div class="addon">

                                                        <?php if ($session['_id']) { ?>
                                                            <b class="tooltip-demo"><a href="javascript:void(0)"
                                                                                       onclick="showFormAddPlaylist()"
                                                                                       class="cd-signin tooltip-top"
                                                                                       title="Thêm vào play list"><i class="fa fa-plus"></i></a></b>
                                                        <?php } else { ?>
                                                            <b class="add-like tooltip-demo">
                                                                <a href="javascript:void(0)" class="cd-signin tooltip-top"
                                                                   title="Thêm vào play list">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            </b>
                                                        <?php } ?>
                                                      
                                                        <a href="/download.html?id=<?php echo $item['_id']; ?>"
                                                           class="tooltip-top"
                                                           title="Tải về"><i
                                                                    class="fa fa-download"></i></a>
                                                        <a href="javascript:void(0)" class="tooltip-top" title="Chia sẻ"><i
                                                                    class="fa fa-share-alt"></i></a>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php } else { ?>
                                    <p>Chưa cập nhật!</p>
                                <?php } ?>
                                <div class="td_heading"><h2><span class="while"><a href="<?php echo $object->link; ?>?t=album">Album</a> (<span id="clkeyword"><?php echo $countalbum; ?></span>)<i class="fa fa-angle-right"></i></span></h2></div>
                                <?php if ($listalbum) { ?>
                                    <div class="row">
                                        <?php foreach ($listalbum as $item) { ?>
                                            <div class="col-md-3 col-sm-4 col-xs-6">
                                                <div class="block-music">
                                                    <div class="cover-outer-align">
                                                        <a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>">
                                                            <img class="cover-image" src="<?php echo $item['priavatar']; ?>"
                                                                 alt="<?php echo $item['name']; ?>"/>
                                                        </a>
                                               <span class="icon-circle-play">
                                                   <a class="button" href="<?php echo $item['link']; ?>"
                                                      title="<?php echo $item['name']; ?>"><i class="fa fa-play"></i></a>
                                               </span>
                                                    </div>

                                                    <div class="details">
                                                        <h3><a class="title" href="<?php echo $item['link']; ?>"
                                                               title=""><?php echo $item['name']; ?>
                                                                <span class="paragraph-end"></span></a></h3>

                                                        <div class="hide-ns">
    <?php if ($item['listartist']) { ?>
    <?php $v174238425172688778021iterator = $item['listartist']; $v174238425172688778021incr = 0; $v174238425172688778021loop = new stdClass(); $v174238425172688778021loop->length = count($v174238425172688778021iterator); $v174238425172688778021loop->index = 1; $v174238425172688778021loop->index0 = 1; $v174238425172688778021loop->revindex = $v174238425172688778021loop->length; $v174238425172688778021loop->revindex0 = $v174238425172688778021loop->length - 1; ?><?php foreach ($v174238425172688778021iterator as $itemchild) { ?><?php $v174238425172688778021loop->first = ($v174238425172688778021incr == 0); $v174238425172688778021loop->index = $v174238425172688778021incr + 1; $v174238425172688778021loop->index0 = $v174238425172688778021incr; $v174238425172688778021loop->revindex = $v174238425172688778021loop->length - $v174238425172688778021incr; $v174238425172688778021loop->revindex0 = $v174238425172688778021loop->length - ($v174238425172688778021incr + 1); $v174238425172688778021loop->last = ($v174238425172688778021incr == ($v174238425172688778021loop->length - 1)); ?>
    <a class="subtitle" href="<?php echo $itemchild['link']; ?>"
       title="<?php echo $itemchild['username']; ?>"><?php echo $itemchild['username']; ?></a><?php if (!$v174238425172688778021loop->last) { ?><span class="bull" style="font-size:12px;">Ft </span><?php } ?>
    <?php $v174238425172688778021incr++; } ?>
    <span class="paragraph-end"></span>
    <?php } ?>
</div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } else { ?>
                                    <p>Chưa cập nhật!</p>
                                <?php } ?>
                                <div class="td_heading"><h2><span class="while"><a href="<?php echo $object->link; ?>?t=video">Video</a> (<span id="clkeyword"><?php echo $countvideo; ?></span>)<i class="fa fa-angle-right"></i></span></h2></div>
                                <?php if ($listvideo) { ?>
                                    <div class="row">
                                        <?php foreach ($listvideo as $item) { ?>
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <div class="block-music">
                                                    <div class="cover-outer-align">
                                                        <a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>">
                                                            <img class="img-responsive" src="<?php echo $item['priavatar']; ?>"
                                                                 alt="<?php echo $item['name']; ?>"/>
                                                        </a>
                                           <span class="icon-circle-play">
                                               <a class="button" href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>"><i
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
    <?php $v174238425172688778021iterator = $item['listartist']; $v174238425172688778021incr = 0; $v174238425172688778021loop = new stdClass(); $v174238425172688778021loop->length = count($v174238425172688778021iterator); $v174238425172688778021loop->index = 1; $v174238425172688778021loop->index0 = 1; $v174238425172688778021loop->revindex = $v174238425172688778021loop->length; $v174238425172688778021loop->revindex0 = $v174238425172688778021loop->length - 1; ?><?php foreach ($v174238425172688778021iterator as $itemchild) { ?><?php $v174238425172688778021loop->first = ($v174238425172688778021incr == 0); $v174238425172688778021loop->index = $v174238425172688778021incr + 1; $v174238425172688778021loop->index0 = $v174238425172688778021incr; $v174238425172688778021loop->revindex = $v174238425172688778021loop->length - $v174238425172688778021incr; $v174238425172688778021loop->revindex0 = $v174238425172688778021loop->length - ($v174238425172688778021incr + 1); $v174238425172688778021loop->last = ($v174238425172688778021incr == ($v174238425172688778021loop->length - 1)); ?>
    <a class="subtitle" href="<?php echo $itemchild['link']; ?>"
       title="<?php echo $itemchild['username']; ?>"><?php echo $itemchild['username']; ?></a><?php if (!$v174238425172688778021loop->last) { ?><span class="bull" style="font-size:12px;">Ft </span><?php } ?>
    <?php $v174238425172688778021incr++; } ?>
    <span class="paragraph-end"></span>
    <?php } ?>
</div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } else { ?>
                                    <p>Chưa cập nhật!</p>
                                <?php } ?>

                            </section>
                        </div>
                        <!-- /content -->
                    </div>
                    <!-- /tabs -->


                </div>

                <div class="col-ldh-3 col-sm-4">
                    <div class="sidebar">
                        <h2 class="heading">NGHỆ SĨ TƯƠNG TỰ</h2>

                        <ul class="dsartist">
                            <?php foreach ($listartist as $item) { ?>
                                <li>
                                    <a href="<?php echo $item['link']; ?>" title="<?php echo $item['username']; ?>" class="thumb pull-left">
                                        <img src="<?php echo $item['priavatar']; ?>" alt="<?php echo $item['username']; ?>">
                                    </a>

                                    <h3 class="song-name">
                                        <a href="<?php echo $item['link']; ?>" title="<?php echo $item['username']; ?>"
                                           class="txt-primary"><?php echo $item['username']; ?></a></h3>

                                    
                                    <a href="<?php echo $item['link']; ?>"><i class="button-follow fa fa-plus"></i></a>
                                </li>
                            <?php } ?>

                        </ul>

                    </div>
                </div>

            </div>
        </div>
    </div>


</div>
<footer>
    <div class="container">
        <div class="row">
            <?php $v174238425172688778021iterator = $listCategory_footer; $v174238425172688778021incr = 0; $v174238425172688778021loop = new stdClass(); $v174238425172688778021loop->length = count($v174238425172688778021iterator); $v174238425172688778021loop->index = 1; $v174238425172688778021loop->index0 = 1; $v174238425172688778021loop->revindex = $v174238425172688778021loop->length; $v174238425172688778021loop->revindex0 = $v174238425172688778021loop->length - 1; ?><?php foreach ($v174238425172688778021iterator as $index => $itemFooterMenu) { ?><?php $v174238425172688778021loop->first = ($v174238425172688778021incr == 0); $v174238425172688778021loop->index = $v174238425172688778021incr + 1; $v174238425172688778021loop->index0 = $v174238425172688778021incr; $v174238425172688778021loop->revindex = $v174238425172688778021loop->length - $v174238425172688778021incr; $v174238425172688778021loop->revindex0 = $v174238425172688778021loop->length - ($v174238425172688778021incr + 1); $v174238425172688778021loop->last = ($v174238425172688778021incr == ($v174238425172688778021loop->length - 1)); ?>
                <?php if ($index % 5 == 0) { ?>
                    <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="list1">
                <?php } ?>
                <li><a href="<?php echo $itemFooterMenu['link']; ?>"><?php echo $itemFooterMenu['title']; ?></a></li>
                <?php if ($index % 5 == 4 || $v174238425172688778021loop->last) { ?>
                    </ul>
                    </div>
                <?php } ?>
            <?php $v174238425172688778021incr++; } ?>

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



<input type="hidden" id="atid" value="<?php echo $object->_id; ?>">

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
</script>
