
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
    <div class="bg-news">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/"><i class="fa fa-home fa-lg"></i></a></li>
                <?php if ($object->type == 'news') { ?>
                    <li><a href="/tin-tuc.html">Tin tức</a></li>
                <?php } else { ?>
                    <li><a href="/anh.html">Ảnh</a></li>
                <?php } ?>
                <?php foreach ($listcategory as $item) { ?>
                    <li><a href="<?php echo $item['link']; ?>"><?php echo $item['name']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-ldh-9 col-sm-8">

                    <div class="row">
                        <div class="bg-news">
                            <article class="thumbnail-news-view">
                                <h2><?php echo $object->name; ?></h2>
                                
                                <div class="post_content">
                                    <?php echo $object->content; ?>
                                </div>
                                <div class="block_timer_share">
                                    <div class="block_timer2 pull-left">
                                        <p class="boutdislike">
                                            <i class="fa fa-user"></i> Người gửi:
                                            <a href="<?php echo $object->usercreatelink; ?>" style="color: #c73030;"
                                               title="<?php echo $object->usercreate; ?>"><?php echo $object->usercreate; ?></a>
                                            (<?php echo $object->usercreate_namerole; ?>) &nbsp;&nbsp;
                                            <i class="fa fa-calendar-o"></i> <?php echo date('d/m/y | H:i:s', $object->datecreate); ?>
                                        </p>

                                    </div>
                                    <input type="hidden" id="url_article" value="<?php echo $currentLink; ?>"/>
                                    <div class="block_share pull-right">
                                        <a rel="nofollow" href="javascript:void(0)" onclick="share_facebook()" title="Chia sẻ bài viết lên facebook">
                                            <img alt="" src="/web/skins/images/icon_fb.gif"></a>
                                        <a rel="nofollow" href="javascript:void(0)" onclick="share_twitter()" data-url="" title="Chia sẻ bài viết lên twitter">
                                            <img alt="" src="/web/skins/images/icon_tw.gif"></a>
                                        <a rel="nofollow" href="javascript:void(0)" onclick="share_goole()" title="Chia sẻ bài viết lên google+">
                                            <img alt="" src="/web/skins/images/icon_google.gif"></a>
                                    </div>
                                </div>
                                <input type="hidden" id="type" value="news">
                                <?php if ($session['_id']) { ?>
                                    <ul class="media-func">
                                        <li><i class="fa fa-eye"> <?php echo $object->view; ?></i> lượt xem</li>
                                        <li>
                                            <span class="boutlike">
                                                <i class="fa fa-thumbs-up"
                                                   id="icon-like" <?php if ($check_like->_id) { ?> style="color: blue;" <?php } ?>></i> <?php echo $object->like; ?>
                                            </span>
                                            <a href="javascript:void(0)"
                                               onclick="likeArticle(this);"
                                               like="<?php echo $object->like; ?>"
                                               checklike="<?php echo ($check_like->_id > 0 ? 1 : 0); ?>"
                                               data-id="<?php echo $object->_id; ?>">Thích
                                            </a>
                                        </li>
                                        <li>
                                             <span class="boutdislike">
                                            <i class="fa fa-thumbs-down"
                                               id="icon-dislike" <?php if ($check_dislike->_id) { ?> style="color: blue;" <?php } ?>></i> <?php echo $object->dislike; ?>
                                                 </span>
                                            <a href="javascript:void(0)" onclick="dislikeArticle(this);"
                                               data-id="<?php echo $object->_id; ?>" checklike="<?php echo ($check_dislike->_id > 0 ? 1 : 0); ?>">Không
                                                thích</a>
                                        </li>
                                    </ul>
                                <?php } else { ?>
                                    <ul class="media-func">
                                        <li class=""><i class="fa fa-eye"> <?php echo $object->view; ?></i> lượt xem</li>
                                        <li class="main-nav">
                                            <i class="fa fa-thumbs-up"></i> <?php echo $object->like; ?>
                                            <a class="cd-signin" href="javascript:void(0)">Thích </a>
                                        </li>
                                        <li class="main-nav">
                                            <i class="fa fa-thumbs-down"></i> <?php echo $object->dislike; ?>
                                            <a class="cd-signin" href="javascript:void(0)">Không thích</a>
                                        </li>
                                    </ul>
                                <?php } ?>
                                <?php if ($listtags) { ?>
                                    <div class="block_timer pull-left"><span class="tags">
                                                    <strong><i class="fa fa-tags"></i> Tags:</strong>
                                            <?php foreach ($listtags as $item) { ?>
                                                <a href="<?php echo $item['link']; ?>"><?php echo $item['name']; ?></a> &nbsp;
                                            <?php } ?>

                                        </span> &nbsp;&nbsp;&nbsp;&nbsp;
                                    </div>
                                <?php } ?>
                                <div style="clear: both"></div>
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
                                <ul class="other-news-detail">
                                    <?php if ($object->type == 'news') { ?>
                                        <h2><span>Tin liên quan</span></h2>
                                    <?php } else { ?>
                                        <h2><span>Ảnh liên quan</span></h2>
                                    <?php } ?>
                                    <?php foreach ($articlerelative as $item) { ?>
                                        <li>
                                            <span><a href="<?php echo $item['link']; ?>"
                                                     title="<?php echo $item['name']; ?>"> <?php echo $item['name']; ?></a></span>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </article>


                        </div>

                    </div>

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
<footer>
    <div class="container">
        <div class="row">
            <?php $v132206916851576595041iterator = $listCategory_footer; $v132206916851576595041incr = 0; $v132206916851576595041loop = new stdClass(); $v132206916851576595041loop->length = count($v132206916851576595041iterator); $v132206916851576595041loop->index = 1; $v132206916851576595041loop->index0 = 1; $v132206916851576595041loop->revindex = $v132206916851576595041loop->length; $v132206916851576595041loop->revindex0 = $v132206916851576595041loop->length - 1; ?><?php foreach ($v132206916851576595041iterator as $index => $itemFooterMenu) { ?><?php $v132206916851576595041loop->first = ($v132206916851576595041incr == 0); $v132206916851576595041loop->index = $v132206916851576595041incr + 1; $v132206916851576595041loop->index0 = $v132206916851576595041incr; $v132206916851576595041loop->revindex = $v132206916851576595041loop->length - $v132206916851576595041incr; $v132206916851576595041loop->revindex0 = $v132206916851576595041loop->length - ($v132206916851576595041incr + 1); $v132206916851576595041loop->last = ($v132206916851576595041incr == ($v132206916851576595041loop->length - 1)); ?>
                <?php if ($index % 5 == 0) { ?>
                    <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="list1">
                <?php } ?>
                <li><a href="<?php echo $itemFooterMenu['link']; ?>"><?php echo $itemFooterMenu['title']; ?></a></li>
                <?php if ($index % 5 == 4 || $v132206916851576595041loop->last) { ?>
                    </ul>
                    </div>
                <?php } ?>
            <?php $v132206916851576595041incr++; } ?>

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



<script type="text/javascript" src="/web/js/myfunction.js"></script>
<script>
    var p = 1;
    $(document).ready(function () {
        loadComment();
    });
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
    function likeMedia(obj) {
        var checklike = $(obj).attr('checklike');
        var atid = $(obj).data('id');
        var type = $('#type').val();
        var total_like = parseInt($(obj).attr('like'));
        $.get("/incoming/likemedia", {atid: atid, checklike: checklike, type: type}, function (re) {
            if (re.status == 200) {
                if (checklike == 0) {
                    $(obj).attr('checklike', 1);
                    $('#icon-like').css('color', 'blue');
                }
                else if (checklike == 1) {
                    $(obj).attr('checklike', 0);
                    $('#icon-like').css('color', '#c73030');
                }
                alert(re.mss);
            }
            else {
                alert(re.mss);
            }
        });
    }

    function dislikeMedia(obj) {
        var type = $('#type').val();
        var checklike = $(obj).attr('checklike');
        var atid = $(obj).data('id');
        var total_like = $(obj).like;
        $.get("/incoming/dislikemedia", {atid: atid, checklike: checklike, type: type}, function (re) {
            if (re.status == 200) {
                if (checklike == 0) {
                    $(obj).attr('checklike', 1);
                    $('#icon-dislike').css('color', 'blue');
                }
                else if (checklike == 1) {
                    $(obj).attr('checklike', 0);
                    $('#icon-dislike').css('color', '#c73030');
                }
                alert(re.mss);
            }
            else {
                alert(re.mss);
            }
        });
    }
</script>