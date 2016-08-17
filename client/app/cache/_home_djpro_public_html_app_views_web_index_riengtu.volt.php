
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
                    <div class="row">
                        <div class="bg-newss">
                            <article class="thumbnail-news-view">
                                <div class="post_content">
                                    <div class="download-block terms-block">
                                        <div class="center"><h2>CHÍNH SÁCH RIÊNG TƯ CỦA MẠNG XÃ HỘI DJ.PRO.VN</h2></div>
                                        <p>Chúng tôi tôn trọng và tận tâm bảo vệ sự riêng tư của người dùng. Chính sách
                                            Bảo vệ riêng tư này nhằm giải quyết những thông tin nhận biết cá nhân (sau
                                            đây gọi là "Dữ liệu") có thể được chúng tôi thu thập. Chính sách Bảo vệ
                                            riêng tư này không áp dụng đối với những bên tham gia mà chúng tôi không
                                            kiểm soát hoặc những người không phải nhân viên, đại lý của chúng tôi hoặc
                                            nằm trong quyền kiểm soát của chúng tôi. Xin vui lòng dành chút thời gian
                                            đọc kỹ Quy định sử dụng để hiểu rõ hơn về các hành vi được phép và không
                                            được phép thực hiện tại hệ thống chúng tôi.</p>

                                        <h3>1. Thu thập Dữ liệu</h3>

                                        <p>Quy trình đăng ký của chúng tôi chỉ yêu cầu một địa chỉ e-mail hợp lệ, một
                                            thông tin nhận dạng người dùng không bị trùng lặp (user ID) và mật khẩu.
                                            Việc cung cấp những thông tin khác cho chúng tôi hay không tùy thuộc vào
                                            quyết định của bạn. Vui lòng lưu ý rằng user ID, e-mail, hoặc những thông
                                            tin bạn cung cấp có thể chứa tên thật hoặc những thông tin cá nhân và vì vậy
                                            có thể xuất hiện trên website chúng tôi.</p>

                                        <p>Cũng giống như nhiều website khác, chúng tôi có thể tự động ghi nhận những
                                            thông tin chung nằm trong các tập tin trên máy chủ của chúng tôi như địa chỉ
                                            IP của bạn hoặc thông tin cookie.</p>

                                        <h3>2. Sử dụng Dữ liệu</h3>

                                        <p>Chúng tôi có thể sử dụng Dữ liệu để tùy biến và cải tiến nhằm phục vụ bạn tốt
                                            hơn. Chúng tôi sẽ cố gắng để Dữ liệu của bạn không bị các bên thứ ba khai
                                            thác, ngoại trừ các trường hợp (i) Được quy định khác trong bản Chính sách
                                            Bảo vệ Riêng tư này; (ii) Chúng tôi được bạn chấp thuận, như đồng ý hoặc
                                            chấm dứt chia sẻ dữ liệu; (iii) Một dịch vụ do website của chúng tôi cung
                                            cấp yêu cầu sự tương tác với một bên thứ ba hoặc do bên thứ ba cung cấp;
                                            (iv) Theo các quy trình hành pháp hoặc luật pháp; (v) Chúng tôi phát hiện
                                            việc bạn sử dụng website này vi phạm Chính sách Bảo vệ Riêng tư, Quy định sử
                                            dụng hoặc các hướng dẫn sử dụng khác do chúng tôi đặt ra nhằm bảo vệ quyền
                                            lợi và/hoặc tài sản hợp pháp của mình; (vi) Website này được mua bởi một bên
                                            thứ ba và họ tiếp tục sử dụng Dữ liệu theo cách thức mà chúng tôi đã quy
                                            định trong bản Chính sách Bảo vệ Riêng tư này. Trong trường hợp bạn sử dụng
                                            liên kết trên site của chúng tôi để truy cập các website khác, đề nghị bạn
                                            đọc kỹ các chính sách bảo vệ sự riêng tư trên các website đó.</p>

                                        <h3>3. Cookies</h3>

                                        <p>Cũng như nhiều website khác, chúng tôi thiết lập và sử dụng cookie để nâng
                                            cao sự cảm thụ của bạn, cũng như duy trì thiết lập cá nhân của bạn...
                                            Website của chúng tôi có thể đăng quảng cáo, và trong trường hợp đó có thể
                                            thiết lập và truy cập các cookie trên máy tính của bạn và phụ thuộc vào
                                            chính sách bảo vệ sự riêng tư của các bên cung cấp quảng cáo. Tuy nhiên, các
                                            công ty quảng cáo không được truy cập vào cookie của chúng tôi. Những công
                                            ty đó thường sử dụng các đoạn mã riêng để theo dõi số lượt truy cập của bạn
                                            đến website của chúng tôi.</p>

                                        <h3>4. Điều khoản với trẻ nhỏ</h3>

                                        <p>Chúng tôi không cho phép người dưới 13 tuổi làm thành viên của site này. Để
                                            có thêm thông tin, vui lòng liên hệ với quản trị.</p>

                                        <h3>5. Biên tập lại hoặc xóa thông tin Tài khoản</h3>

                                        <p>Chúng tôi cung cấp tính năng biên tập thông tin trong tài khoản cá nhân thông
                                            qua trang cấu hình cá nhân riêng của bạn. Bạn có thể yêu cầu xóa bỏ tài
                                            khoản của bạn bằng cách liên lạc với quản trị. Nội dung hoặc các dữ liệu mà
                                            bạn đã cung cấp cho chúng tôi không nằm trong tài khoản cá nhân của bạn,
                                            chẳng hạn các bài viết (post) trên diễn đàn, có thể tiếp tục nằm trên
                                            website của chúng tôi ngay cả khi tài khoản của bạn đã bị xóa. Xin vui lòng
                                            đọc kỹ Quy định sử dụng để có thêm thông tin.</p>

                                        <h3>6. Thay đổi điều khoản</h3>

                                        <p>Chúng tôi có thể thay đổi các điều khoản của bản Chính sách Bảo vệ Riêng tư
                                            này cho phù hợp với điều kiện thực tế. Chúng tôi sẽ thông báo về những thay
                                            đổi lớn bằng cách đặt thông báo trên site của chúng tôi hoặc gửi thư điện tử
                                            tới địa chỉ e-mail mà bạn đã cung cấp và được đặt trong thiết lập người dùng
                                            của bạn.</p>

                                        <h3>7. Từ chối bảo đảm</h3>

                                        <p>Mặc dù Chính sách Bảo vệ riêng tư đặt ra những tiêu chuẩn về Dữ liệu và chúng
                                            tôi luôn cố gắng hết mình để đáp ứng, chúng tôi không bị buộc phải bảo đảm
                                            những tiêu chuẩn đó. Có thể có những nhân tố vượt ra ngoài tầm kiểm soát của
                                            chúng tôi có thể dẫn đến việc Dữ liệu bị tiết lộ. Vì thế, chúng tôi không
                                            chịu trách nhiệm bảo đảm Dữ liệu luôn được duy trì ở tình trạng hoàn hảo
                                            hoặc không bị tiết lộ.</p>

                                        <h3>8. Sự đồng ý của bạn</h3>

                                        <p>Khi sử dụng dịch vụ của chúng tôi, bạn mặc nhiên chấp nhận điều khoản trong
                                            Chính sách Bảo vệ Riêng tư này. Muốn biết thêm thông tin, vui lòng liên lạc
                                            với chúng tôi tại địa chỉ webmaster@vinagame.com.vn. Chúng tôi hoạt động
                                            hoàn toàn trong khuôn khổ luật pháp Việt Nam và cam kết tuân thủ các pháp
                                            chế của Nhà nước Cộng hòa Xã hội Chủ nghĩa Việt Nam . Các điều khoản trên là
                                            phù hợp với luật pháp hiện hành và đảm bảo quyền lợi cao nhất cho người sử
                                            dụng dịch vụ của chúng tôi.</p>

                                        <h3>9. Thông tin liên hệ</h3>

                                        <p>Nếu bạn có thắc mắc về Chính sách Bảo vệ sự Riêng tư, vui lòng bấm vào đây để
                                            liên hệ với quản trị.</p>

                                        <h3>10. Phụ lục: Giải thích các khái niệm</h3>
                                        <b><i>a. Những thông tin gì được thu thập và thu thập như thế nào?</i></b>

                                        <p>Mỗi máy tính nối mạng đều được xác định bởi một chuỗi số gọi là "Giao thức
                                            Internet" hay địa chỉ IP. Khi người dùng có một yêu cầu gửi đến máy chủ của
                                            chúng tôi trong khi truy cập vào trang, máy chủ sẽ nhận ra người thông qua
                                            địa chỉ IP đó. Điều này sẽ không ảnh hưởng gì đến những thông tin cá nhân
                                            của bạn ngoài việc nhận ra một máy tính đang truy cập chúng tôi. Chúng tôi
                                            dùng thông tin này để xác lập thống kê về lượng truy cập toàn cục, và để xem
                                            có sự lạm dụng băng thông hay không nhằm phối hợp với các chính sách pháp
                                            luật ban hành về an ninh mạng. Chúng tôi hoàn toàn không thu thập thông tin
                                            về một cá nhân cụ thể. Máy chủ của chúng tôi không tự động ghi nhận các địa
                                            chỉ email của người dùng.</p>
                                        <b><i>b. Cookies là gì?</i></b>

                                        <p>Trong thời gian bạn truy cập chúng tôi, chúng tôi hoặc các nhà tài trợ có thể
                                            gửi "cookie" đến máy tính của bạn. Cookie là một mẩu nhỏ thông tin gửi đến
                                            trình duyệt Internet từ máy chủ và lưu lại trên ổ cứng. Cookie không thể đọc
                                            thông tin trên ổ cứng của bạn hay thông tin của các cookie được gửi đến bởi
                                            các trang Web khác. Cookie vô hại với hệ thống của bạn. Chúng tôi dùng
                                            Cookie để thống kê các trang thuộc hệ thống chúng tôi mà các bạn đã truy
                                            cập, và trong lần ghé thăm kế tiếp của bạn, bạn sẽ truy cập những trang đó
                                            nhanh hơn. Các nhà tài trợ của chúng tôi cũng dùng cookie để chắc chắn về số
                                            lượt truy cập của các bạn tới các banner của họ trên chúng tôi. Các nhà tài
                                            trợ có thể dùng thông tin này để thay đổi các chính sách quảng cáo trên
                                            chúng tôi để đạt được hiệu quả cao nhất cho các chương trình của họ (Dựa vào
                                            trang có số lượng vào nhiều nhất để đặt banner là 1 ví dụ). Bạn có toàn
                                            quyền lựa chọn có cho phép cookie thay đổi thông tin về trình duyệt của bạn
                                            hay không. Bạn cũng có thể chọn từ chối tất cả các cookie được gửi đến. Nếu
                                            bạn chọn như vậy có thể một số tính năng của chúng tôi cũng như các website
                                            khác, sẽ không hoạt động tốt.</p>
                                        <b><i>c. chúng tôi dùng "ảnh gif điểm đơn " (single-pixel gifs) như thế nào?</i></b>

                                        <p>Chúng tôi và các nhà tài trợ có thể sử dụng "ảnh gif điểm đơn", đôi khi được
                                            đề cập đến như các con bọ (beacon) hay cọc mốc trong trong môi trường Web,
                                            để đếm số trang được truy cập và thu thập một số thông tin thống kê chung.
                                            chúng tôi không thu thập thông tin cá nhân thông qua việc sử dụng các ảnh
                                            này. Các nhà tài trợ của chúng tôi cũng chỉ theo dõi qua việc dùng ảnh này
                                            để xác nhận các thông số về banner quảng cáo.</p>
                                        <b><i>d. chúng tôi thu thập thông tin gì khi người dùng đăng ký?</i></b>

                                        <p>Với một số dịch vụ chúng tôi yêu cầu người dùng phải đăng ký. Chúng tôi có
                                            thể dùng thông tin này để gửi thông báo cho bạn về các sản phẩm và dịch vụ
                                            thông qua thư điện tử hoặc thư bưu chính. Trong trường hợp bạn đăng ký sử
                                            dụng các dịch vụ giá trị gia tăng do các bên thứ ba cung cấp thì các thông
                                            tin đó có thể được chia sẻ với các khách hàng của chúng tôi (Các nhà tài
                                            trợ) để họ có thể gửi thông tin hoặc đồ khuyến mãi tới người dùng liên quan
                                            đến các dịch vụ và bạn đã đăng ký.</p>

                                        <p>Chúng tôi có thể sẽ sử dụng các địa chỉ thư điện tử và thư bưu chính để tiến
                                            hành các cuộc điều tra (Ví dụ: thông báo thay đổi dịch vụ trên chúng tôi,
                                            thông báo về các chương trình khuyến mại hay các hành động nhân đạo và xã
                                            hội khác). Chúng tôi duy trì chính sách "Không Spam" và không chia sẻ, bán
                                            hay để lọt email của các bạn cho các bên thứ ba khi không có sự chấp thuận
                                            của bạn.</p>

                                        <p>Nếu bạn đồng ý với việc nhận các thông tin về các chương trình và dịch vụ của
                                            các hãng thứ 3 khi đăng ký, bạn sẽ có thể nhận được các thông tin thông qua
                                            thư điện tử hoặc thư bưu chính từ các hãng tài trợ này.</p>
                                    </div>
                                </div>

                                <ul class="other-news-detail">
                                    <h2><span>Tin khác</span></h2>
                                    <li><span><a href="/dieu-khoan-thoa-thuan.html" title="">Điều khoản thỏa
                                                thuận</a></span></li>
                                    <li><span><a href="/chinh-sach-ban-quyen.html" title="">Chính sách bản
                                                quyền</a></span></li>
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



