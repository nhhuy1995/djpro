

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
                            <div class="info-summary-title"><h1><?php echo $object->username; ?></h1></div>
                            <?php if ($object->description) { ?>
                                <p><?php echo $object->description; ?> <a href="<?php echo $object->link; ?>?t=info">Tiểu sử <?php echo $object->username; ?></a></p>
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
                                <li class="tabs_artist "><a href="<?php echo $object->link; ?>"
                                                                       class="icon icon-all"><span>Tất cả</span></a>
                                </li>
                                <li class="tabs_artist tab-current"><a href="<?php echo $object->link; ?>?t=audio" class="icon icon-baihat"><span>Bài hát đã đăng</span></a>
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
                            <section id="section-linemove-2" style="display: block">
                                <div class="td_heading"><h2><span class="while">Bài hát<i class="fa fa-angle-right"></i></span>
                                    </h2></div>
                                <?php if ($listmedia) { ?>
                                    <div data-special-type="app">
                                        <ul class="listtop">
                                            <?php foreach ($listmedia as $key => $item) { ?>
                                                <li><a href="<?php echo $item['link']; ?>"><span><?php echo $key + 1; ?>
                                                            . </span><?php echo $item['name']; ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <div class="pagination">
    <ul class="paginationBar">
        <li><a href="<?php echo $painginfo['currentlink']; ?>p=<?php echo ($painginfo['page'] - 1 <= 1 ? 1 : $painginfo['page'] - 1); ?>"
               class="navigation-button"> Trước </a></li>
        <?php foreach ($painginfo['rangepage'] as $index => $item) { ?>
            <li class="<?php echo ($item == $painginfo['page'] ? 'active' : ''); ?>">
                <?php if ($item == $painginfo['page']) { ?>
                    <a class="active"><?php echo $item; ?></a>
                <?php } else { ?>
                    <a href="<?php echo $painginfo['currentlink']; ?>p=<?php echo $item; ?>" class=""><?php echo $item; ?></a>
                <?php } ?>
            </li>
        <?php } ?>
        <li>
            <a href="<?php echo $painginfo['currentlink']; ?>p=<?php echo ($painginfo['page'] + 1 >= $painginfo['totalpage'] ? $painginfo['totalpage'] : $painginfo['page'] + 1); ?>"
               class="navigation-button">Sau</a></li>
    </ul>
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
            <?php $v31061286420683915211iterator = $listCategory_footer; $v31061286420683915211incr = 0; $v31061286420683915211loop = new stdClass(); $v31061286420683915211loop->length = count($v31061286420683915211iterator); $v31061286420683915211loop->index = 1; $v31061286420683915211loop->index0 = 1; $v31061286420683915211loop->revindex = $v31061286420683915211loop->length; $v31061286420683915211loop->revindex0 = $v31061286420683915211loop->length - 1; ?><?php foreach ($v31061286420683915211iterator as $index => $itemFooterMenu) { ?><?php $v31061286420683915211loop->first = ($v31061286420683915211incr == 0); $v31061286420683915211loop->index = $v31061286420683915211incr + 1; $v31061286420683915211loop->index0 = $v31061286420683915211incr; $v31061286420683915211loop->revindex = $v31061286420683915211loop->length - $v31061286420683915211incr; $v31061286420683915211loop->revindex0 = $v31061286420683915211loop->length - ($v31061286420683915211incr + 1); $v31061286420683915211loop->last = ($v31061286420683915211incr == ($v31061286420683915211loop->length - 1)); ?>
                <?php if ($index % 5 == 0) { ?>
                    <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="list1">
                <?php } ?>
                <li><a href="<?php echo $itemFooterMenu['link']; ?>"><?php echo $itemFooterMenu['title']; ?></a></li>
                <?php if ($index % 5 == 4 || $v31061286420683915211loop->last) { ?>
                    </ul>
                    </div>
                <?php } ?>
            <?php $v31061286420683915211incr++; } ?>

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


