
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

    <div class="banner-gs">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/trang-chu.html"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/chu-de.html">Chủ đề</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="divpre">
                <a href="<?php echo $header->link; ?>" title="<?php echo $header->name; ?>" alt="<?php echo $header->name; ?>">
                    <img height="350" alt="chủ đề" src="<?php echo (empty($header->banner) ? ('/web/images/relax.jpg') : ($header->banner)); ?>">
                </a>

                <div class="box-info-artist">
                    <div class="info-artist fluid">

                        <div class="caption-cd">
                            <a href="<?php echo $header->link; ?>" title="<?php echo $header->name; ?>" alt="<?php echo $header->name; ?>">
                                <div class="info-summary-title"><h1><?php echo $header->name; ?></h1></div>
                            </a>
                            <p><?php echo $header->description; ?>
                                <?php if ($header->artist) { ?>
                                -
                                <?php $v116062975773978940311iterator = $header->artist; $v116062975773978940311incr = 0; $v116062975773978940311loop = new stdClass(); $v116062975773978940311loop->length = count($v116062975773978940311iterator); $v116062975773978940311loop->index = 1; $v116062975773978940311loop->index0 = 1; $v116062975773978940311loop->revindex = $v116062975773978940311loop->length; $v116062975773978940311loop->revindex0 = $v116062975773978940311loop->length - 1; ?><?php foreach ($v116062975773978940311iterator as $item) { ?><?php $v116062975773978940311loop->first = ($v116062975773978940311incr == 0); $v116062975773978940311loop->index = $v116062975773978940311incr + 1; $v116062975773978940311loop->index0 = $v116062975773978940311incr; $v116062975773978940311loop->revindex = $v116062975773978940311loop->length - $v116062975773978940311incr; $v116062975773978940311loop->revindex0 = $v116062975773978940311loop->length - ($v116062975773978940311incr + 1); $v116062975773978940311loop->last = ($v116062975773978940311incr == ($v116062975773978940311loop->length - 1)); ?>
                                <a href="<?php echo $item['link']; ?>" title="<?php echo $item['username']; ?>" target="_blank"
                                   alt="<?php echo $item['username']; ?>"><?php echo $item['username']; ?></a> <?php if (!$v116062975773978940311loop->last) { ?>ft <?php } ?>
                                <?php $v116062975773978940311incr++; } ?>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="row">

                <div class="col-md-12 col-sm-12">
                    <div class="td_heading">
                        <h2>
                            <a href="/chu-de-noi-bat.html">
                                <span>CHỦ ĐỀ NỔI BẬT<i class="fa fa-angle-right"></i></span>
                            </a>
                        </h2>
                    </div>

                    <div class="topic_chude">
                        <ul class="row">
                            <?php $v116062975773978940311iterator = $listtopic; $v116062975773978940311incr = 0; $v116062975773978940311loop = new stdClass(); $v116062975773978940311loop->length = count($v116062975773978940311iterator); $v116062975773978940311loop->index = 1; $v116062975773978940311loop->index0 = 1; $v116062975773978940311loop->revindex = $v116062975773978940311loop->length; $v116062975773978940311loop->revindex0 = $v116062975773978940311loop->length - 1; ?><?php foreach ($v116062975773978940311iterator as $item) { ?><?php $v116062975773978940311loop->first = ($v116062975773978940311incr == 0); $v116062975773978940311loop->index = $v116062975773978940311incr + 1; $v116062975773978940311loop->index0 = $v116062975773978940311incr; $v116062975773978940311loop->revindex = $v116062975773978940311loop->length - $v116062975773978940311incr; $v116062975773978940311loop->revindex0 = $v116062975773978940311loop->length - ($v116062975773978940311incr + 1); $v116062975773978940311loop->last = ($v116062975773978940311incr == ($v116062975773978940311loop->length - 1)); ?>
                            <li class="col-md-4 col-sm-4 col-xs-12">
                                <div>
                                    <?php $v116062975773978940312iterator = $item['listtopic']; $v116062975773978940312incr = 0; $v116062975773978940312loop = new stdClass(); $v116062975773978940312loop->length = count($v116062975773978940312iterator); $v116062975773978940312loop->index = 1; $v116062975773978940312loop->index0 = 1; $v116062975773978940312loop->revindex = $v116062975773978940312loop->length; $v116062975773978940312loop->revindex0 = $v116062975773978940312loop->length - 1; ?><?php foreach ($v116062975773978940312iterator as $itemchild) { ?><?php $v116062975773978940312loop->first = ($v116062975773978940312incr == 0); $v116062975773978940312loop->index = $v116062975773978940312incr + 1; $v116062975773978940312loop->index0 = $v116062975773978940312incr; $v116062975773978940312loop->revindex = $v116062975773978940312loop->length - $v116062975773978940312incr; $v116062975773978940312loop->revindex0 = $v116062975773978940312loop->length - ($v116062975773978940312incr + 1); $v116062975773978940312loop->last = ($v116062975773978940312incr == ($v116062975773978940312loop->length - 1)); ?>
                                        <?php if ($v116062975773978940312loop->first) { ?>
                                            <a title="" target="_top" href="<?php echo $itemchild['link']; ?>"
                                               class="box_absolute">
                                                <span class="icon_play"></span>
                                                <img alt="<?php echo $itemchild['name']; ?>" title="<?php echo $itemchild['name']; ?>"
                                                     src="<?php echo $itemchild['small_banner']; ?>">
                                            </a>

                                            <h2><a class="name_topic" href="<?php echo $itemchild['link']; ?>"
                                                   title="<?php echo $itemchild['name']; ?>"><?php echo $itemchild['name']; ?></a></h2>
                                        <?php } ?>
                                    <?php $v116062975773978940312incr++; } ?>
                                    <ul>
                                        <?php $v116062975773978940312iterator = $item['listtopic']; $v116062975773978940312incr = 0; $v116062975773978940312loop = new stdClass(); $v116062975773978940312loop->length = count($v116062975773978940312iterator); $v116062975773978940312loop->index = 1; $v116062975773978940312loop->index0 = 1; $v116062975773978940312loop->revindex = $v116062975773978940312loop->length; $v116062975773978940312loop->revindex0 = $v116062975773978940312loop->length - 1; ?><?php foreach ($v116062975773978940312iterator as $itemchild) { ?><?php $v116062975773978940312loop->first = ($v116062975773978940312incr == 0); $v116062975773978940312loop->index = $v116062975773978940312incr + 1; $v116062975773978940312loop->index0 = $v116062975773978940312incr; $v116062975773978940312loop->revindex = $v116062975773978940312loop->length - $v116062975773978940312incr; $v116062975773978940312loop->revindex0 = $v116062975773978940312loop->length - ($v116062975773978940312incr + 1); $v116062975773978940312loop->last = ($v116062975773978940312incr == ($v116062975773978940312loop->length - 1)); ?>
                                        <?php if (!$v116062975773978940312loop->first) { ?>
                                        <li>
                                            <h3><a class="name_song" title="<?php echo $itemchild['name']; ?>"
                                                   alt="<?php echo $itemchild['name']; ?>"
                                                   href="<?php echo $itemchild['link']; ?>"><?php echo $itemchild['name']; ?></a>
                                            </h3>
                                        </li>
                                        <?php } ?>
                                        <?php $v116062975773978940312incr++; } ?>

                                    </ul>
                                </div>
                            </li>
                            <?php $v116062975773978940311incr++; } ?>
                        </ul>
                    </div>
                    <div class="td_heading">
                        <h2>
                            <a href="/chu-de-moi.html">
                                <span>CHỦ ĐỀ MỚI NHẤT<i class="fa fa-angle-right"></i></span>
                            </a>
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <?php $v116062975773978940311iterator = $listTopic_New; $v116062975773978940311incr = 0; $v116062975773978940311loop = new stdClass(); $v116062975773978940311loop->length = count($v116062975773978940311iterator); $v116062975773978940311loop->index = 1; $v116062975773978940311loop->index0 = 1; $v116062975773978940311loop->revindex = $v116062975773978940311loop->length; $v116062975773978940311loop->revindex0 = $v116062975773978940311loop->length - 1; ?><?php foreach ($v116062975773978940311iterator as $item) { ?><?php $v116062975773978940311loop->first = ($v116062975773978940311incr == 0); $v116062975773978940311loop->index = $v116062975773978940311incr + 1; $v116062975773978940311loop->index0 = $v116062975773978940311incr; $v116062975773978940311loop->revindex = $v116062975773978940311loop->length - $v116062975773978940311incr; $v116062975773978940311loop->revindex0 = $v116062975773978940311loop->length - ($v116062975773978940311incr + 1); $v116062975773978940311loop->last = ($v116062975773978940311incr == ($v116062975773978940311loop->length - 1)); ?>
                        <div class="col-md-3 col-sm-4 col-xs-6">
                            <div class="block-music">
                                <div class="cover-outer-align">
                                    <a href="<?php echo $item['link']; ?>">
                                        <img class="img-responsive" src="<?php echo $item['priavatar']; ?>"
                                             alt="<?php echo $item['name']; ?>" title="<?php echo $item['name']; ?>"/>
                                    </a>
                           <span class="icon-circle-play">
                               <a class="button" href="<?php echo $item['link']; ?>" title=""><i class="fa fa-play"></i></a>
                           </span>
                                </div>
                                <div class="details">
                                    <h3><a href="<?php echo $item['link']; ?>" class="title tooltip-top"
                                           title="<?php echo $item['name']; ?>"><?php echo $item['name']; ?>
                                            <span class="paragraph-end"></span></a></h3>
                                    <div class="hide-ns">
    <?php if ($item['listartist']) { ?>
    <?php $v116062975773978940311iterator = $item['listartist']; $v116062975773978940311incr = 0; $v116062975773978940311loop = new stdClass(); $v116062975773978940311loop->length = count($v116062975773978940311iterator); $v116062975773978940311loop->index = 1; $v116062975773978940311loop->index0 = 1; $v116062975773978940311loop->revindex = $v116062975773978940311loop->length; $v116062975773978940311loop->revindex0 = $v116062975773978940311loop->length - 1; ?><?php foreach ($v116062975773978940311iterator as $itemchild) { ?><?php $v116062975773978940311loop->first = ($v116062975773978940311incr == 0); $v116062975773978940311loop->index = $v116062975773978940311incr + 1; $v116062975773978940311loop->index0 = $v116062975773978940311incr; $v116062975773978940311loop->revindex = $v116062975773978940311loop->length - $v116062975773978940311incr; $v116062975773978940311loop->revindex0 = $v116062975773978940311loop->length - ($v116062975773978940311incr + 1); $v116062975773978940311loop->last = ($v116062975773978940311incr == ($v116062975773978940311loop->length - 1)); ?>
    <a class="subtitle" href="<?php echo $itemchild['link']; ?>"
       title="<?php echo $itemchild['username']; ?>"><?php echo $itemchild['username']; ?></a><?php if (!$v116062975773978940311loop->last) { ?><span class="bull" style="font-size:12px;">Ft </span><?php } ?>
    <?php $v116062975773978940311incr++; } ?>
    <span class="paragraph-end"></span>
    <?php } ?>
</div>
                                </div>
                            </div>
                        </div>
                    <?php $v116062975773978940311incr++; } ?>
                </div>
                <div class="td_heading">

                    <h2>
                        <a href="/chu-de-chon-loc.html">
                            <span>CHỦ ĐỀ CHỌN LỌC<i class="fa fa-angle-right"></i></span>
                        </a>
                    </h2>
                </div>
            </div>
            <div class="row">
                <?php $v116062975773978940311iterator = $listTopicSelectvie; $v116062975773978940311incr = 0; $v116062975773978940311loop = new stdClass(); $v116062975773978940311loop->length = count($v116062975773978940311iterator); $v116062975773978940311loop->index = 1; $v116062975773978940311loop->index0 = 1; $v116062975773978940311loop->revindex = $v116062975773978940311loop->length; $v116062975773978940311loop->revindex0 = $v116062975773978940311loop->length - 1; ?><?php foreach ($v116062975773978940311iterator as $item) { ?><?php $v116062975773978940311loop->first = ($v116062975773978940311incr == 0); $v116062975773978940311loop->index = $v116062975773978940311incr + 1; $v116062975773978940311loop->index0 = $v116062975773978940311incr; $v116062975773978940311loop->revindex = $v116062975773978940311loop->length - $v116062975773978940311incr; $v116062975773978940311loop->revindex0 = $v116062975773978940311loop->length - ($v116062975773978940311incr + 1); $v116062975773978940311loop->last = ($v116062975773978940311incr == ($v116062975773978940311loop->length - 1)); ?>
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="block-music">
                            <div class="cover-outer-align">
                                <a href="<?php echo $item['link']; ?>">
                                    <img class="img-responsive" title="<?php echo $item['name']; ?>" src="<?php echo $item['priavatar']; ?>"
                                         alt="<?php echo $item['name']; ?>"/>
                                </a>
                           <span class="icon-circle-play">
                               <a class="button" href="<?php echo $item['link']; ?>" title=""><i class="fa fa-play"></i></a>
                           </span>
                            </div>
                            <div class="details">
                                <h3><a href="<?php echo $item['link']; ?>" class="title tooltip-top"
                                       title="<?php echo $item['name']; ?>"><?php echo $item['name']; ?>
                                        <span class="paragraph-end"></span></a></h3>
                                <div class="hide-ns">
    <?php if ($item['listartist']) { ?>
    <?php $v116062975773978940311iterator = $item['listartist']; $v116062975773978940311incr = 0; $v116062975773978940311loop = new stdClass(); $v116062975773978940311loop->length = count($v116062975773978940311iterator); $v116062975773978940311loop->index = 1; $v116062975773978940311loop->index0 = 1; $v116062975773978940311loop->revindex = $v116062975773978940311loop->length; $v116062975773978940311loop->revindex0 = $v116062975773978940311loop->length - 1; ?><?php foreach ($v116062975773978940311iterator as $itemchild) { ?><?php $v116062975773978940311loop->first = ($v116062975773978940311incr == 0); $v116062975773978940311loop->index = $v116062975773978940311incr + 1; $v116062975773978940311loop->index0 = $v116062975773978940311incr; $v116062975773978940311loop->revindex = $v116062975773978940311loop->length - $v116062975773978940311incr; $v116062975773978940311loop->revindex0 = $v116062975773978940311loop->length - ($v116062975773978940311incr + 1); $v116062975773978940311loop->last = ($v116062975773978940311incr == ($v116062975773978940311loop->length - 1)); ?>
    <a class="subtitle" href="<?php echo $itemchild['link']; ?>"
       title="<?php echo $itemchild['username']; ?>"><?php echo $itemchild['username']; ?></a><?php if (!$v116062975773978940311loop->last) { ?><span class="bull" style="font-size:12px;">Ft </span><?php } ?>
    <?php $v116062975773978940311incr++; } ?>
    <span class="paragraph-end"></span>
    <?php } ?>
</div>
                            </div>
                        </div>
                    </div>
                <?php $v116062975773978940311incr++; } ?>
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
            <?php $v116062975773978940311iterator = $listCategory_footer; $v116062975773978940311incr = 0; $v116062975773978940311loop = new stdClass(); $v116062975773978940311loop->length = count($v116062975773978940311iterator); $v116062975773978940311loop->index = 1; $v116062975773978940311loop->index0 = 1; $v116062975773978940311loop->revindex = $v116062975773978940311loop->length; $v116062975773978940311loop->revindex0 = $v116062975773978940311loop->length - 1; ?><?php foreach ($v116062975773978940311iterator as $item) { ?><?php $v116062975773978940311loop->first = ($v116062975773978940311incr == 0); $v116062975773978940311loop->index = $v116062975773978940311incr + 1; $v116062975773978940311loop->index0 = $v116062975773978940311incr; $v116062975773978940311loop->revindex = $v116062975773978940311loop->length - $v116062975773978940311incr; $v116062975773978940311loop->revindex0 = $v116062975773978940311loop->length - ($v116062975773978940311incr + 1); $v116062975773978940311loop->last = ($v116062975773978940311incr == ($v116062975773978940311loop->length - 1)); ?>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="list1">
                        <li style="font-weight: bold;;"><a href="<?php echo $item['link']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>"><?php echo $item['title']; ?></a></li>
                        <?php if (isset($item['child'])) { ?>
                            <?php $v116062975773978940312iterator = $item['child']; $v116062975773978940312incr = 0; $v116062975773978940312loop = new stdClass(); $v116062975773978940312loop->length = count($v116062975773978940312iterator); $v116062975773978940312loop->index = 1; $v116062975773978940312loop->index0 = 1; $v116062975773978940312loop->revindex = $v116062975773978940312loop->length; $v116062975773978940312loop->revindex0 = $v116062975773978940312loop->length - 1; ?><?php foreach ($v116062975773978940312iterator as $child) { ?><?php $v116062975773978940312loop->first = ($v116062975773978940312incr == 0); $v116062975773978940312loop->index = $v116062975773978940312incr + 1; $v116062975773978940312loop->index0 = $v116062975773978940312incr; $v116062975773978940312loop->revindex = $v116062975773978940312loop->length - $v116062975773978940312incr; $v116062975773978940312loop->revindex0 = $v116062975773978940312loop->length - ($v116062975773978940312incr + 1); $v116062975773978940312loop->last = ($v116062975773978940312incr == ($v116062975773978940312loop->length - 1)); ?>
                                <li><a href="<?php echo $child['link']; ?>" alt="<?php echo $child['title']; ?>" title="<?php echo $child['title']; ?>"><?php echo $child['title']; ?></a></li>
                            <?php $v116062975773978940312incr++; } ?>
                        <?php } ?>
                    </ul>
                </div>
            <?php $v116062975773978940311incr++; } ?>
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


