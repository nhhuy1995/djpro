<link rel="stylesheet" href="/web/skins/charts.css"/>

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

<?php if ($session['_id']) { ?>
    <?php $clparent = ''; ?>
    <?php $clchildren = ''; ?>
<?php } else { ?>
    <?php $clparent = 'main-nav'; ?>
    <?php $clchildren = 'cd-signin'; ?>
<?php } ?>
<div id="content">

    <div class="bg-BXH">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/trang-chu.html"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/bxh.html">Bảng xếp hạng</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="row">

                <div class="col-ldh-9 col-sm-8">

                    <div class="td_heading">
                        <h2>
                            <span class="while">Bảng xếp hạng<i class="fa fa-angle-right"></i></span></h2>
                    </div>

                    <div class="tabs tabs-style-iconbox">
                        <nav>
                            <ul>
                                <li class=""><a href="/bxh.html" class="icon icon-baihat"><span>Bài hát</span></a>
                                </li>
                                <li class=""><a href="/bxh.html?t=video"
                                                class="icon icon-video"><span>Video</span></a></li>
                                    <li class="<?php if ($_GET['t'] == 'topic') { ?> tab-current <?php } ?>"><a href="/bxh.html?t=topic"
                                                    class="icon icon-chude"><span>Chủ đề</span></a></li>
                                    <li class="<?php if ($_GET['t'] == 'album') { ?> tab-current <?php } ?>"><a href="/bxh.html?t=album"
                                                    class="icon icon-album"><span>Album</span></a></li>
                                    <li class="<?php if ($_GET['t'] == 'playlist') { ?> tab-current <?php } ?>"><a href="/bxh.html?t=playlist"
                                                    class="icon icon-playlist"><span>Playlist</span></a></li>
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-linemove-4" class="content-current">
                                <?php foreach ($listAlbum as $key => $item) { ?>
                                <?php $cl = 'secondary-visible'; ?>
                                <?php if ($key == 0) { ?> <?php $cl = 'row-new secondary-visible'; ?> <?php } ?>
                                <article class="chart-row <?php echo $cl; ?>">
                                    <div class="row-primary">
                                        <?php if (!isset($item['increase'])) { ?>
                                            <div class="row-history row-history-new"></div>
                                            <div class="row-award-indicator"><i class="fa fa-star"></i></div>
                                            <div class="row-new-indicator">Mới</div>
                                        <?php } elseif ($item['increase'] >= 0) { ?>
                                            <div class="row-history row-history-rising"></div>
                                            <div class="row-award-indicator"><i class="fa fa-star"></i></div>
                                        <?php } else { ?>
                                            <div class="row-history row-history-falling"></div>
                                        <?php } ?>
                                        <div class="row-bullet"><i class="fa fa-dot-circle-o"></i></div>
                                        <div class="row-rank">
                                            <span class="this-week"><?php echo $key + 1; ?></span>
                                                <span class="last-week">
                                                    Tuần trước: <?php if (!isset($item['increase'])) { ?> -- <?php } else { ?> <?php echo $item['last_week']; ?> <?php } ?>
                                                </span>
                                        </div>
                                        <div class="row-image"><a href="<?php echo $item['link']; ?>"
                                                                  title="<?php echo $item['name']; ?>"><img
                                                        src="<?php echo $item['priavatar']; ?>" alt="<?php echo $item['name']; ?>"/></a>
                                        </div>
                                        <div class="row-title">
                                            <a href="<?php echo $item['link']; ?>" class="title_audio" title="<?php echo $item['name']; ?>">
                                                <h2><?php echo $item['name']; ?></h2>
                                            </a>

                                            <h3>
                                                <?php if ($item['artist']) { ?>
                                                <?php $v85536929890070250132iterator = $item['artist']; $v85536929890070250132incr = 0; $v85536929890070250132loop = new stdClass(); $v85536929890070250132loop->length = count($v85536929890070250132iterator); $v85536929890070250132loop->index = 1; $v85536929890070250132loop->index0 = 1; $v85536929890070250132loop->revindex = $v85536929890070250132loop->length; $v85536929890070250132loop->revindex0 = $v85536929890070250132loop->length - 1; ?><?php foreach ($v85536929890070250132iterator as $itemchild) { ?><?php $v85536929890070250132loop->first = ($v85536929890070250132incr == 0); $v85536929890070250132loop->index = $v85536929890070250132incr + 1; $v85536929890070250132loop->index0 = $v85536929890070250132incr; $v85536929890070250132loop->revindex = $v85536929890070250132loop->length - $v85536929890070250132incr; $v85536929890070250132loop->revindex0 = $v85536929890070250132loop->length - ($v85536929890070250132incr + 1); $v85536929890070250132loop->last = ($v85536929890070250132incr == ($v85536929890070250132loop->length - 1)); ?>
                                                <a href="<?php echo $itemchild['link']; ?>"
                                                   title="<?php echo $itemchild['username']; ?>"><?php echo $itemchild['username']; ?></a>
                                                <?php if (!$v85536929890070250132loop->last) { ?><span
                                                        style="font-weight: normal;">ft</span><?php } ?>
                                                    <?php $v85536929890070250132incr++; } ?>
                                                <?php } ?>
                                            </h3>
                                            <span><i class="fa fa-headphones"></i> <?php echo $item['view']; ?></span>
                                        </div>
                                        <div class="row-secondary-toggle"><a href="#"><i
                                                        class="fa fa-angle-down"></i></a></div>
                                    </div>

                                    <div class="row-secondary">
                                        <div class="stats">
                                            <div class="stats-last-week">
                                                <span class="label">Tuần trước</span>
                                                    <span class="value">
                                                      <?php if (!isset($item['increase'])) { ?> -- <?php } else { ?> <?php echo $item['last_week']; ?> <?php } ?>
                                                    </span>
                                            </div>
                                            <div class="stats-top-spot">
                                                <span class="label">Vị trí cao nhất</span>
                                                <span class="value"><?php echo $item['highest'] + 1; ?></span>
                                            </div>
                                            <div class="stats-weeks-on-chart">
                                                <span class="label">Vị trí<br>TB</span>
                                                <span class="value">1</span>
                                            </div>
                                        </div>
                                        <ul class="fa-ul row-awards">
                                            <?php if ($key == 0) { ?>
                                                <li><i class="fa fa-li fa-angle-double-up"></i> Vị trí cao nhất
                                                    trong BXH
                                                </li>
                                            <?php } ?>
                                            <?php if ($item['increase'] > 0) { ?>
                                                <li><i class="fa fa-li fa-dot-circle-o"></i> Tăng trong tuần</li>
                                            <?php } else { ?>
                                                <li><i class="fa fa-li fa-dot-circle-o"></i> Giảm trong tuần</li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </article>
                                <?php } ?>
                            </section>
                        </div>
                        <!-- /content -->
                    </div>
                    <!-- /tabs -->


                </div>


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
        <h2 class="heading">Có thể bạn muốn nghe</h2>

        <div class="main-boder">
            <div data-special-type="app" class="player-container2">
                <div data-special-type="app" class="player-container2">
                    <ul class="listtop">

                        <?php foreach ($listMusic as $key => $item) { ?>
                            <?php $cl = 'special-4'; ?>
                            <?php if ($key == 0) { ?> <?php $cl = 'special-1'; ?> <?php } ?>
                            <?php if ($key == 1) { ?> <?php $cl = 'special-2'; ?> <?php } ?>
                            <?php if ($key == 2) { ?> <?php $cl = 'special-3'; ?> <?php } ?>
                            <li><a href="<?php echo $item['link']; ?>"><span
                                            class="number <?php echo $cl; ?>"><?php echo $key + 1; ?></span><?php echo $item['name']; ?>
                                </a></li>
                        <?php } ?>
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
            <?php foreach ($listCategory_footer as $item) { ?>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="list1">
                        <li style="font-weight: bold;;"><a href="<?php echo $item['link']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>"><?php echo $item['title']; ?></a></li>
                        <?php if (isset($item['child'])) { ?>
                            <?php $v85536929890070250132iterator = $item['child']; $v85536929890070250132incr = 0; $v85536929890070250132loop = new stdClass(); $v85536929890070250132loop->length = count($v85536929890070250132iterator); $v85536929890070250132loop->index = 1; $v85536929890070250132loop->index0 = 1; $v85536929890070250132loop->revindex = $v85536929890070250132loop->length; $v85536929890070250132loop->revindex0 = $v85536929890070250132loop->length - 1; ?><?php foreach ($v85536929890070250132iterator as $child) { ?><?php $v85536929890070250132loop->first = ($v85536929890070250132incr == 0); $v85536929890070250132loop->index = $v85536929890070250132incr + 1; $v85536929890070250132loop->index0 = $v85536929890070250132incr; $v85536929890070250132loop->revindex = $v85536929890070250132loop->length - $v85536929890070250132incr; $v85536929890070250132loop->revindex0 = $v85536929890070250132loop->length - ($v85536929890070250132incr + 1); $v85536929890070250132loop->last = ($v85536929890070250132incr == ($v85536929890070250132loop->length - 1)); ?>
                                <li><a href="<?php echo $child['link']; ?>" alt="<?php echo $child['title']; ?>" title="<?php echo $child['title']; ?>"><?php echo $child['title']; ?></a></li>
                            <?php $v85536929890070250132incr++; } ?>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
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


