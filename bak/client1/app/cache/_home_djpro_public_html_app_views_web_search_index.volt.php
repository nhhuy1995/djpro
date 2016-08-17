
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
            <ul class="breadcrumbs">
                <li><a href="/trang-chu.html"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/tim-kiem.html?q=<?php echo $keyword; ?>"><?php echo $_GET['q']; ?></a></li>
                <li>Có tất cả "<?php echo $countTotal; ?>" kết quả</li>
            </ul>
        </div>
        <div class="container">
            <div class="row">

                <div class="col-ldh-9 col-sm-8">
                    

                    <div class="td_heading"><h2><span class="while">Danh sách nhạc theo
                                “<a href="/tim-kiem/nhac.html?q=<?php echo $keyword; ?>"><span id="clkeyword"><?php echo $_GET['q']; ?></span></a>”
                                (<?php echo $countaudio; ?>)
                                <i class="fa fa-angle-right"></i></span>
                        </h2></div>
                    <?php if ($listaudio) { ?>
                        <div data-special-type="app" class="player-container">
                            <ul id="playlist" class="song-list">
                                <?php foreach ($listaudio as $item) { ?>
                                    <li>
                                <span class="song-title">
                                    <a href="<?php echo $item['link']; ?>" class="tooltip-top"
                                       title="<?php echo $item['name']; ?>"><?php echo $item['name']; ?> </a>
                                </span>
                                <span class="song-duration">
                                    <b class="tooltip-demo"><a href="<?php echo $item['link']; ?>" class="tooltip-top"
                                                               title="Play"><i
                                                    class="fa fa-play"></i></a></b>
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

                                    <b class="tooltip-demo"><a href="/download?id=<?php echo $item['_id']; ?>" class="tooltip-top"
                                                               title="Tải về"><i
                                                    class="fa fa-download"></i></a></b>
                                </span>
                                        <span class="song-listen"><i
                                                    class="fa fa-headphones"></i> <?php echo $item['view']; ?></span>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>

                    <?php } else { ?>
                        <p>Không có kết quả nào cho "<?php echo $_GET['q']; ?>" </p>
                    <?php } ?>
                    <!--  Artist  --->
                    <div class="td_heading"><h2><span class="while">Danh sách nghệ sỹ theo
                                “<a href="/tim-kiem/nghe-sy.html?q=<?php echo $keyword; ?>"><span id="clkeyword"><?php echo $_GET['q']; ?></span></a>”
                               (<?php echo $countartist; ?>)
                                <i class="fa fa-angle-right"></i></span></h2></div>
                    <?php if ($listartist) { ?>
                        <div class="row">
                            <?php foreach ($listartist as $item) { ?>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="block-music">
                                        <div class="cover-outer-align">
                                            <a href="<?php echo $item['link']; ?>">
                                                <img class="img-responsive" title="<?php echo $item['username']; ?>"
                                                     src="<?php echo $item['priavatar']; ?>"
                                                     alt="<?php echo $item['username']; ?>"/>
                                            </a>
                           <span class="icon-plus">
                               <a href="<?php echo $item['link']; ?>" title=""><i class="fa fa-plus"></i></a>
                           </span>
                                        </div>

                                        <div class="details2">
                                            <h3><a href="<?php echo $item['link']; ?>" class="title tooltip-top"
                                                   title="<?php echo $item['username']; ?>"><?php echo $item['username']; ?>
                                                    <span class="paragraph-end"></span></a></h3>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <p>Không có kết quả nào cho "<?php echo $_GET['q']; ?>" </p>
                    <?php } ?>
                    <div class="td_heading"><h2><span class="while">Danh sách album theo
                                “<a href="/tim-kiem/album.html?q=<?php echo $keyword; ?>"><span id="clkeyword"><?php echo $_GET['q']; ?></span></a>”
                                (<?php echo $countalbum; ?>)
                                <i class="fa fa-angle-right"></i></span>
                        </h2>
                    </div>
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
                                   <a class="button" href="<?php echo $item['link']; ?>" title=""><i class="fa fa-play"></i></a>
                               </span>
                                        </div>

                                        <div class="details">
                                            <h3><a class="title" href="<?php echo $item['link']; ?>"
                                                   title="<?php echo $item['name']; ?>"><?php echo $item['name']; ?>
                                                    <span class="paragraph-end"></span></a></h3>

                                            <div class="hide-ns">
    <?php if ($item['listartist']) { ?>
    <?php $v72855492092859893821iterator = $item['listartist']; $v72855492092859893821incr = 0; $v72855492092859893821loop = new stdClass(); $v72855492092859893821loop->length = count($v72855492092859893821iterator); $v72855492092859893821loop->index = 1; $v72855492092859893821loop->index0 = 1; $v72855492092859893821loop->revindex = $v72855492092859893821loop->length; $v72855492092859893821loop->revindex0 = $v72855492092859893821loop->length - 1; ?><?php foreach ($v72855492092859893821iterator as $itemchild) { ?><?php $v72855492092859893821loop->first = ($v72855492092859893821incr == 0); $v72855492092859893821loop->index = $v72855492092859893821incr + 1; $v72855492092859893821loop->index0 = $v72855492092859893821incr; $v72855492092859893821loop->revindex = $v72855492092859893821loop->length - $v72855492092859893821incr; $v72855492092859893821loop->revindex0 = $v72855492092859893821loop->length - ($v72855492092859893821incr + 1); $v72855492092859893821loop->last = ($v72855492092859893821incr == ($v72855492092859893821loop->length - 1)); ?>
    <a class="subtitle" href="<?php echo $itemchild['link']; ?>"
       title="<?php echo $itemchild['username']; ?>"><?php echo $itemchild['username']; ?></a><?php if (!$v72855492092859893821loop->last) { ?><span class="bull" style="font-size:12px;">Ft </span><?php } ?>
    <?php $v72855492092859893821incr++; } ?>
    <span class="paragraph-end"></span>
    <?php } ?>
</div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <p>Không có kết quả nào cho "<?php echo $_GET['q']; ?>" </p>
                    <?php } ?>
                    <div class="td_heading">
                        <h2><span class="while">Danh sách playlist theo
                                “<a href="/tim-kiem/playlist.html?q=<?php echo $keyword; ?>"><span id="clkeyword"><?php echo $_GET['q']; ?></span></a>”
                                (<?php echo $countplaylist; ?>)
                                <i class="fa fa-angle-right"></i></span>
                        </h2>
                    </div>
                    <?php if ($listplaylist) { ?>
                        <div class="row">
                            <?php foreach ($listplaylist as $item) { ?>
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="block-music">
                                        <div class="cover-outer-align">
                                            <a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>">
                                                <img class="cover-image" src="<?php echo $item['priavatar']; ?>"
                                                     alt="<?php echo $item['name']; ?>"/>
                                            </a>
                               <span class="icon-circle-play">
                                   <a class="button" href="<?php echo $item['link']; ?>" title=""><i class="fa fa-play"></i></a>
                               </span>
                                        </div>

                                        <div class="details">
                                            <h3><a class="title" href="<?php echo $item['link']; ?>"
                                                   title="<?php echo $item['name']; ?>"><?php echo $item['name']; ?>
                                                    <span class="paragraph-end"></span></a></h3>

                                            <div class="hide-ns">
    <?php if ($item['listartist']) { ?>
    <?php $v72855492092859893821iterator = $item['listartist']; $v72855492092859893821incr = 0; $v72855492092859893821loop = new stdClass(); $v72855492092859893821loop->length = count($v72855492092859893821iterator); $v72855492092859893821loop->index = 1; $v72855492092859893821loop->index0 = 1; $v72855492092859893821loop->revindex = $v72855492092859893821loop->length; $v72855492092859893821loop->revindex0 = $v72855492092859893821loop->length - 1; ?><?php foreach ($v72855492092859893821iterator as $itemchild) { ?><?php $v72855492092859893821loop->first = ($v72855492092859893821incr == 0); $v72855492092859893821loop->index = $v72855492092859893821incr + 1; $v72855492092859893821loop->index0 = $v72855492092859893821incr; $v72855492092859893821loop->revindex = $v72855492092859893821loop->length - $v72855492092859893821incr; $v72855492092859893821loop->revindex0 = $v72855492092859893821loop->length - ($v72855492092859893821incr + 1); $v72855492092859893821loop->last = ($v72855492092859893821incr == ($v72855492092859893821loop->length - 1)); ?>
    <a class="subtitle" href="<?php echo $itemchild['link']; ?>"
       title="<?php echo $itemchild['username']; ?>"><?php echo $itemchild['username']; ?></a><?php if (!$v72855492092859893821loop->last) { ?><span class="bull" style="font-size:12px;">Ft </span><?php } ?>
    <?php $v72855492092859893821incr++; } ?>
    <span class="paragraph-end"></span>
    <?php } ?>
</div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <p>Không có kết quả nào cho "<?php echo $_GET['q']; ?>" </p>
                    <?php } ?>
                    <div class="td_heading"><h2><span class="while">Danh sách chủ đề theo
                                “<a href="/tim-kiem/chu-de.html?q=<?php echo $keyword; ?>"><span id="clkeyword"><?php echo $_GET['q']; ?></span></a>”
                                (<?php echo $counttopic; ?>)
                                <i class="fa fa-angle-right"></i></span>
                        </h2>
                    </div>
                    <?php if ($listtopic) { ?>
                        <div class="row">
                            <?php foreach ($listtopic as $item) { ?>
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="block-music">
                                        <div class="cover-outer-align">
                                            <a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>">
                                                <img class="cover-image" src="<?php echo $item['priavatar']; ?>"
                                                     alt="<?php echo $item['name']; ?>"/>
                                            </a>
                               <span class="icon-circle-play">
                                   <a class="button" href="<?php echo $item['link']; ?>" title=""><i class="fa fa-play"></i></a>
                               </span>
                                        </div>

                                        <div class="details">
                                            <h3><a class="title" href="<?php echo $item['link']; ?>"
                                                   title="<?php echo $item['name']; ?>"><?php echo $item['name']; ?>
                                                    <span class="paragraph-end"></span></a></h3>

                                            <div class="hide-ns">
    <?php if ($item['listartist']) { ?>
    <?php $v72855492092859893821iterator = $item['listartist']; $v72855492092859893821incr = 0; $v72855492092859893821loop = new stdClass(); $v72855492092859893821loop->length = count($v72855492092859893821iterator); $v72855492092859893821loop->index = 1; $v72855492092859893821loop->index0 = 1; $v72855492092859893821loop->revindex = $v72855492092859893821loop->length; $v72855492092859893821loop->revindex0 = $v72855492092859893821loop->length - 1; ?><?php foreach ($v72855492092859893821iterator as $itemchild) { ?><?php $v72855492092859893821loop->first = ($v72855492092859893821incr == 0); $v72855492092859893821loop->index = $v72855492092859893821incr + 1; $v72855492092859893821loop->index0 = $v72855492092859893821incr; $v72855492092859893821loop->revindex = $v72855492092859893821loop->length - $v72855492092859893821incr; $v72855492092859893821loop->revindex0 = $v72855492092859893821loop->length - ($v72855492092859893821incr + 1); $v72855492092859893821loop->last = ($v72855492092859893821incr == ($v72855492092859893821loop->length - 1)); ?>
    <a class="subtitle" href="<?php echo $itemchild['link']; ?>"
       title="<?php echo $itemchild['username']; ?>"><?php echo $itemchild['username']; ?></a><?php if (!$v72855492092859893821loop->last) { ?><span class="bull" style="font-size:12px;">Ft </span><?php } ?>
    <?php $v72855492092859893821incr++; } ?>
    <span class="paragraph-end"></span>
    <?php } ?>
</div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <p>Không có kết quả nào cho "<?php echo $_GET['q']; ?>" </p>
                    <?php } ?>
                    <div class="td_heading"><h2>
                            <span class="while">Danh sách video theo
                                “<a href="/tim-kiem/video.html?q=<?php echo $keyword; ?>"><span id="clkeyword"><?php echo $_GET['q']; ?></span></a>”
                                (<?php echo $countvideo; ?>)
                                <i class="fa fa-angle-right"></i></span>
                        </h2>
                    </div>
                    <?php if ($listvideo) { ?>
                        <div class="row">
                            <?php foreach ($listvideo as $item) { ?>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="block-music">
                                        <div class="cover-outer-align">
                                            <a href="<?php echo $item['link']; ?>" title="<?php echo $item['name']; ?>">
                                                <img class="cover-image" src="<?php echo $item['priavatar']; ?>"
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
                                                   title="<?php echo $item['name']; ?>"> <?php echo $item['name']; ?>
                                                    <span class="paragraph-end"></span></a></h3>

                                            <div class="hide-ns">
    <?php if ($item['listartist']) { ?>
    <?php $v72855492092859893821iterator = $item['listartist']; $v72855492092859893821incr = 0; $v72855492092859893821loop = new stdClass(); $v72855492092859893821loop->length = count($v72855492092859893821iterator); $v72855492092859893821loop->index = 1; $v72855492092859893821loop->index0 = 1; $v72855492092859893821loop->revindex = $v72855492092859893821loop->length; $v72855492092859893821loop->revindex0 = $v72855492092859893821loop->length - 1; ?><?php foreach ($v72855492092859893821iterator as $itemchild) { ?><?php $v72855492092859893821loop->first = ($v72855492092859893821incr == 0); $v72855492092859893821loop->index = $v72855492092859893821incr + 1; $v72855492092859893821loop->index0 = $v72855492092859893821incr; $v72855492092859893821loop->revindex = $v72855492092859893821loop->length - $v72855492092859893821incr; $v72855492092859893821loop->revindex0 = $v72855492092859893821loop->length - ($v72855492092859893821incr + 1); $v72855492092859893821loop->last = ($v72855492092859893821incr == ($v72855492092859893821loop->length - 1)); ?>
    <a class="subtitle" href="<?php echo $itemchild['link']; ?>"
       title="<?php echo $itemchild['username']; ?>"><?php echo $itemchild['username']; ?></a><?php if (!$v72855492092859893821loop->last) { ?><span class="bull" style="font-size:12px;">Ft </span><?php } ?>
    <?php $v72855492092859893821incr++; } ?>
    <span class="paragraph-end"></span>
    <?php } ?>
</div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <p>Không có kết quả nào cho "<?php echo $_GET['q']; ?>" </p>
                    <?php } ?>
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
            <?php $v72855492092859893821iterator = $listCategory_footer; $v72855492092859893821incr = 0; $v72855492092859893821loop = new stdClass(); $v72855492092859893821loop->length = count($v72855492092859893821iterator); $v72855492092859893821loop->index = 1; $v72855492092859893821loop->index0 = 1; $v72855492092859893821loop->revindex = $v72855492092859893821loop->length; $v72855492092859893821loop->revindex0 = $v72855492092859893821loop->length - 1; ?><?php foreach ($v72855492092859893821iterator as $index => $itemFooterMenu) { ?><?php $v72855492092859893821loop->first = ($v72855492092859893821incr == 0); $v72855492092859893821loop->index = $v72855492092859893821incr + 1; $v72855492092859893821loop->index0 = $v72855492092859893821incr; $v72855492092859893821loop->revindex = $v72855492092859893821loop->length - $v72855492092859893821incr; $v72855492092859893821loop->revindex0 = $v72855492092859893821loop->length - ($v72855492092859893821incr + 1); $v72855492092859893821loop->last = ($v72855492092859893821incr == ($v72855492092859893821loop->length - 1)); ?>
                <?php if ($index % 5 == 0) { ?>
                    <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="list1">
                <?php } ?>
                <li><a href="<?php echo $itemFooterMenu['link']; ?>"><?php echo $itemFooterMenu['title']; ?></a></li>
                <?php if ($index % 5 == 4 || $v72855492092859893821loop->last) { ?>
                    </ul>
                    </div>
                <?php } ?>
            <?php $v72855492092859893821incr++; } ?>

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
<!-- form add playlist -->
<div style="display: none;" id="my-playlist-box">
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
            console.log(re);
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


