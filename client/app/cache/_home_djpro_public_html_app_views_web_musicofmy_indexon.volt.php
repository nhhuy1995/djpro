

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


    <div class="artists">
        <div class="container">
            <div class="row">

                <div class="col-ldh-9 col-sm-8">

                    <div class="tabs tabs-style-linemove">
                        <nav>
                            <ul>
                                <li class="tab-current"><a href="/nhac-da-duyet.html"
                                                           class="icon icon-all"><span>Tất cả</span></a></li>
                                <li class=""><a href="/nhac-da-duyet.html?t=audio" class="icon icon-baihat"><span>Bài hát đã đăng</span></a>
                                </li>
                                <li class=""><a href="/nhac-da-duyet.html?t=playlist"
                                                class="icon icon-playlist"><span>Playlist đã đăng</span></a></li>
                                <li class=""><a href="/nhac-da-duyet.html?t=video"
                                                class="icon icon-video"><span>Video đã đăng</span></a></li>
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-linemove-1" class="content-current">
                                <div class="td_heading"><h2><span class="while"><a href="/nhac-da-duyet.html?t=audio">Bài hát</a> (<span id="clkeyword"><?php echo $countaudio; ?></span>)<i class="fa fa-angle-right"></i></span>
                                    </h2></div>
                                <?php if ($listmedia) { ?>
                                    <div data-special-type="app">
                                        <ul class="listtop">
                                            <?php foreach ($listmedia as $key => $item) { ?>
                                                <li><a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>"><span><?php echo $key + 1; ?>
                                                            . </span><?php echo $item['name']; ?>  </a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php } else { ?>
                                    <p>Chưa cập nhật!</p>
                                <?php } ?>
                                <div class="td_heading"><h2><span class="while"><a href="/nhac-da-duyet.html?t=playlist">Playlist</a> (<span id="clkeyword"><?php echo $countplaylist; ?></span>)<i
                                                    class="fa fa-angle-right"></i></span></h2></div>
                                <?php if ($listplaylist) { ?>
                                    <div class="row">
                                        <?php foreach ($listplaylist as $item) { ?>
                                            <div class="col-md-3 col-sm-4 col-xs-6">
                                                <div class="block-music">
                                                    <div class="cover-outer-align">
                                                        <a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>">
                                                            <img class="cover-image" title="<?php echo $item['name']; ?>" src="<?php echo $item['priavatar']; ?>" alt=""/>
                                                        </a>
                                               <span class="icon-circle-play">
                                                   <a class="button" href="<?php echo $item['link']; ?>" title=""><i
                                                               class="fa fa-play"></i></a>
                                               </span>
                                                    </div>

                                                    <div class="details">
                                                        <h3><a class="title" href="<?php echo $item['link']; ?>"
                                                               title=""><?php echo $item['name']; ?>
                                                                <span class="paragraph-end"></span></a></h3>

                                                        <div class="hide-ns">
    <?php if ($item['listartist']) { ?>
    <?php $v176055868519441549531iterator = $item['listartist']; $v176055868519441549531incr = 0; $v176055868519441549531loop = new stdClass(); $v176055868519441549531loop->length = count($v176055868519441549531iterator); $v176055868519441549531loop->index = 1; $v176055868519441549531loop->index0 = 1; $v176055868519441549531loop->revindex = $v176055868519441549531loop->length; $v176055868519441549531loop->revindex0 = $v176055868519441549531loop->length - 1; ?><?php foreach ($v176055868519441549531iterator as $itemchild) { ?><?php $v176055868519441549531loop->first = ($v176055868519441549531incr == 0); $v176055868519441549531loop->index = $v176055868519441549531incr + 1; $v176055868519441549531loop->index0 = $v176055868519441549531incr; $v176055868519441549531loop->revindex = $v176055868519441549531loop->length - $v176055868519441549531incr; $v176055868519441549531loop->revindex0 = $v176055868519441549531loop->length - ($v176055868519441549531incr + 1); $v176055868519441549531loop->last = ($v176055868519441549531incr == ($v176055868519441549531loop->length - 1)); ?>
    <a class="subtitle" href="<?php echo $itemchild['link']; ?>"
       title="<?php echo $itemchild['username']; ?>"><?php echo $itemchild['username']; ?></a><?php if (!$v176055868519441549531loop->last) { ?><span class="bull" style="font-size:12px;">Ft </span><?php } ?>
    <?php $v176055868519441549531incr++; } ?>
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
                                <div class="td_heading"><h2><span class="while"><a href="/nhac-da-duyet.html?t=video">Video</a> (<span id="clkeyword"><?php echo $countvideo; ?></span>)<i
                                                    class="fa fa-angle-right"></i></span></h2></div>
                                <?php if ($listvideo) { ?>
                                    <div class="row">
                                        <?php foreach ($listvideo as $item) { ?>
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <div class="block-music">
                                                    <div class="cover-outer-align">
                                                        <a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>">
                                                            <img class="img-responsive" title="<?php echo $item['name']; ?>" src="<?php echo $item['priavatar']; ?>"
                                                                 alt=""/>
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
                                                                <span class="paragraph-end"></span>
                                                            </a>
                                                        </h3>

                                                        <div class="hide-ns">
    <?php if ($item['listartist']) { ?>
    <?php $v176055868519441549531iterator = $item['listartist']; $v176055868519441549531incr = 0; $v176055868519441549531loop = new stdClass(); $v176055868519441549531loop->length = count($v176055868519441549531iterator); $v176055868519441549531loop->index = 1; $v176055868519441549531loop->index0 = 1; $v176055868519441549531loop->revindex = $v176055868519441549531loop->length; $v176055868519441549531loop->revindex0 = $v176055868519441549531loop->length - 1; ?><?php foreach ($v176055868519441549531iterator as $itemchild) { ?><?php $v176055868519441549531loop->first = ($v176055868519441549531incr == 0); $v176055868519441549531loop->index = $v176055868519441549531incr + 1; $v176055868519441549531loop->index0 = $v176055868519441549531incr; $v176055868519441549531loop->revindex = $v176055868519441549531loop->length - $v176055868519441549531incr; $v176055868519441549531loop->revindex0 = $v176055868519441549531loop->length - ($v176055868519441549531incr + 1); $v176055868519441549531loop->last = ($v176055868519441549531incr == ($v176055868519441549531loop->length - 1)); ?>
    <a class="subtitle" href="<?php echo $itemchild['link']; ?>"
       title="<?php echo $itemchild['username']; ?>"><?php echo $itemchild['username']; ?></a><?php if (!$v176055868519441549531loop->last) { ?><span class="bull" style="font-size:12px;">Ft </span><?php } ?>
    <?php $v176055868519441549531incr++; } ?>
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

                <div class="col-md-3 col-sm-3">
                    <div class="shadow">
                        <div class="img-center">
                            <img src="<?php echo $uinfo['priavatar']; ?>" alt=""/>
                        </div>

                        <div class="summary">
                            
                             <h2 class="title_user">Xin chào:
    <a href="<?php echo $uinfo['link']; ?>" title="<?php echo $uinfo['username']; ?>" style="<?php if ($uinfo['is_role'] == 1) { ?> color: #c73030;<?php } else { ?> color: #176093;<?php } ?>"><?php echo $uinfo['username']; ?></a>
    <span class="role_user"><?php echo $uinfo['namerole']; ?></span>
</h2>
<ul class="menuSub">
    <li><i class="fa fa-user"></i> Họ tên: <?php echo $uinfo['fullname']; ?></li>
    <li><i class="fa fa-birthday-cake"></i> Ngày sinh: <?php echo $uinfo['birthday']; ?></li>
    <li><i class="fa fa-smile-o"></i> Giới tính:  <?php echo $uinfo['sex']; ?> </li>
    <li><i class="fa fa-facebook"></i> Facebook: <?php echo $uinfo['facebook']; ?></li>
    <li><i class="fa fa-yahoo"></i> Yahoo! Messenger: <?php echo $uinfo['yahoo']; ?></li>
    <li><i class="fa fa-skype"></i> Skype: <?php echo $uinfo['skype']; ?></li>
    <li><i class="fa fa-phone"></i> SĐT: <?php echo $uinfo['phone']; ?></li>
    <li><i class="fa fa-bank"></i> Địa chỉ: <?php echo $uinfo['address']; ?></li>
    <li><i class="fa fa-briefcase"></i> Nghề nghiệp: <?php echo $uinfo['job']; ?></li>
    <li><i class="fa fa-gamepad"></i> Sở thích: <?php echo $uinfo['hobby']; ?></li>
    <li><h2 class="title_user"></h2></li>
    <li><h2 >Thống kê</h2></li>
    <li><i class="fa fa-cloud-upload"></i> Số bài đã đăng: <?php echo $uinfo['totalmedia']; ?></li>
    <li><i class="fa fa-thumbs-o-up"></i> Số lần được Like: <?php echo $uinfo['totallikemedia']; ?></li>
    <li><i class="fa fa-thumbs-o-down"></i> Số lần Dislike: <?php echo $uinfo['totaldislikemedia']; ?></li>
    <li><i class="fa fa-comment"></i> Tổng số bình luận: <?php echo $uinfo['totalcomment']; ?></li>
    <li><i class="fa fa-frown-o"></i> Hoạt động gần nhất: <?php echo $uinfo['timeactivity']; ?></li>
    <li><i class="fa fa-user"></i> Trạng thái: <?php if ($uinfo['isonline'] == 1) { ?> Online <?php } else { ?> Offline <?php } ?></li>
</ul>
                        </div>
                    </div>
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
                            <?php foreach ($item['child'] as $child) { ?>
                                <li><a href="<?php echo $child['link']; ?>" alt="<?php echo $child['title']; ?>" title="<?php echo $child['title']; ?>"><?php echo $child['title']; ?></a></li>
                            <?php } ?>
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


