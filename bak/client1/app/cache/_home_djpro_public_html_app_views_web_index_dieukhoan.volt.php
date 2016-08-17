
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
                                        <div class="center"><h2>ĐIỀU KHOẢN THỎA THUẬN CUNG CẤP VÀ SỬ DỤNG DỊCH VỤ MẠNG
                                                XÃ HỘI DJ.PRO.VN</h2></div>

                                        <h3>Các thay đổi với mạng xã hội DJ.Pro.vn</h3>

                                        <p>Chúng tôi, với toàn quyền hạn của mình và vào bất cứ lúc nào được quyền bổ
                                            sung, sửa đổi hay xóa bỏ bất kỳ thông tin nào cũng như thay đổi giao diện,
                                            cách trình bày, thành phần hoặc chức năng, nội dung của trang web này bao
                                            gồm bất kỳ khoản mục nào mà không cần báo trước.</p>

                                        <h3>Thay đổi quy định</h3>

                                        <p>Chúng tôi có toàn quyền thay đổi quy định mà không cần báo trước. Với việc
                                            tiếp tục sử dụng mạng xã hội DJ.Pro.vn sau những sửa đổi đó, bạn mặc nhiên
                                            đồng ý chấp hành các sửa đổi trong quy định.</p>

                                        <h3>Đăng ký và ngừng sử dụng dịch vụ</h3>

                                        <p>Khi đăng ký tài khoản bạn phải đồng ý cung cấp thông tin một cách trung thực,
                                            đầy đủ và cập nhật các thông tin này khi có sự thay đổi trong thực tế. Các
                                            vấn đề thu thập, sử dụng và bảo mât thông tin vui lòng xem trong Chính sách
                                            bảo mật.</p>

                                        <p>Khi đăng ký, bạn sẽ tạo một Tài Khoản DJ.Pro.vn với tên truy cập và một mật
                                            khẩu. Bạn đồng ý chịu trách nhiệm bảo vệ tên truy cập và mật khẩu của mình
                                            để tránh việc người khác sử dụng trái phép và thông báo kịp thời cho
                                            DJ.Pro.vn về bất kỳ việc sử dụng trái phép nào. Việc tạoTài khoản trên điện
                                            thoại sẽ đòi hỏi phải truyền dữ liệu, chi phí truyền dữ liệu nếu có sẽ do
                                            bạn chịu trách nhiệm chi trả.</p>

                                        <p>Bạn có thể chấm dứt việc đăng ký nếu bạn không muốn sử dụng Dịch vụ nữa.
                                            DJ.Pro.vn có thể chấm dứt việc đăng ký của bạn hoặc cấm bạn truy cập vào một
                                            số phần của Dịch vụ nếu có căn cứ xác định bạn đã vi phạm Điều Khoản.</p>

                                        <h3>Hành vi của bạn</h3>

                                        <p>Bạn thừa nhận rằng tất cả thông tin hoặc dữ liệu thuộc bất kỳ dạng nào, dù là
                                            văn bản, phần mềm, mã, nhạc hoặc âm thanh, ảnh hoặc đồ họa, video hoặc các
                                            chất liệu khác ("Nội dung"), được bạn hoặc “người có tài khoản người dùng bị
                                            sử dụng” chia sẻ công khai và rộng rãi trên website hoặc tại các khu vực
                                            trên website cho phép bạn chia sẻ nội dung dưới bất kỳ định dạng nào, sẽ
                                            hoàn toàn thuộc trách nhiệm của bạn hoặc người có tài khoản người dùng bị sử
                                            dụng. Bạn thừa nhận rằng website của chúng tôi có thể đưa bạn đến Nội dung
                                            có thể không phù hợp hoặc phản cảm theo nhận định của cá nhân bạn. Mặc dù
                                            vậy, chúng tôi sẽ không chịu bất kỳ trách nhiệm với bạn trong bất cứ phương
                                            diện nào nào về Nội dung của trang web hay bất cứ tổn thất hoặc lỗi nào có
                                            liên quan.</p>

                                        <h3>Khi sử dụng mạng xã hội DJ.Pro.vn và các dịch vụ được cung cấp, bạn hoàn
                                            toàn đồng ý rằng:</h3>

                                        <p>- Tuyệt đối nghiêm cấm mọi hành vi: tuyên truyền, chống phá và xuyên tạc
                                            chính quyền, thể chế, và các chính sách của nhà nước, kích động bạo lực,
                                            tuyên truyền chiến tranh , gây hận thù giữa các dân tộc và nhân dân các
                                            nước, kích động dâm ô, đồi trụy, tội ác, tệ nạn xã hội, mê tín dị đoan, phá
                                            hoại thuần phong mỹ tục của dân tộc, tiết lộ bí mật nhà nước, bí mật quân
                                            sự, an ninh, kinh tế, đối ngoại và những bí mật khác đã được pháp luật quy
                                            định. Trường hợp phát hiện, không những bị xóa bỏ tài khoản mà chúng tôi còn
                                            có thể cung cấp thông tin của người đó cho các cơ quan chức năng để xử lý
                                            theo pháp luật.</p>

                                        <p>- Không có những hành vi, thái độ làm tổn hại đến uy tín của các sản phẩm của
                                            công ty cũng như công ty phát hành dưới bất kỳ hình thức nào, phương thức
                                            nào. Mọi vi phạm sẽ bị tước bỏ mọi quyền lợi liên quan đối với dịch vụ hoặc
                                            xử lý trước pháp luật nếu cần thiết.</p>

                                        <p>- Nghiêm cấm tổ chức các hình thức cá cược, cờ bạc hoặc các thỏa thuận liên
                                            quan đến tiền, hiện kim, hiện vật.</p>

                                        <p>- Tuyệt đối nghiêm cấm việc xúc phạm, nhạo báng người khác dưới bất kỳ hình
                                            thức nào (nhạo báng, chê bai, kỳ thị tôn giáo, giới tính, sắc tộc….).</p>

                                        <p>- Cấm kêu gọi tổ chức bạo loạn, cấm đăng tải, trao đổi các thông tin về biểu
                                            tình, bạo loạn</p>

                                        <p>- Cấm đăng lại nguồn từ các trang blog cá nhân, diễn đàn, bạn đọc viết trên
                                            các mục báo,…</p>

                                        <p>- Cấm đăng tải bài viết từ các trang có yếu tố nước ngoài như BBC tiếng Việt,
                                            VOA tiếng Việt....</p>

                                        <p>- Nội dung không đi ngược lại thuần phong mĩ tục của Việt Nam và vi phạm pháp
                                            luật nước CHXHCN Việt Nam.</p>

                                        <p>- Nghiêm cấm đưa Đảng Cộng sản Việt Nam, Nhà nước Việt Nam, các thể chế chính
                                            trị, lịch sử, các lãnh tụ vào bàn luận trong những chủ đề không liên
                                            quan.</p>

                                        <p>- Cấm viết bài, trao đổi các thông tin tuyên truyền mê tín dị đoan.</p>

                                        <p>- Tuyệt đối nghiêm cấm mọi hành vi mạo nhận, hay cố ý mạo danh làm người khác
                                            tưởng lầm mình là một người dùng khác. Mọi hành vi vi phạm sẽ bị xử lý hoặc
                                            tước bỏ tài khoản.</p>

                                        <p>- Bạn sẽ không gửi lên hoặc truyền phát bất kỳ thông tin bất hợp pháp, lừa
                                            gạt, bôi nhọ, sỉ nhục, tục tĩu, khiêu dâm, xúc phạm, đe dọa, lăng mạ, thù
                                            hận, kích động… hoặc trái với chuẩn mực đạo đức chung của xã hội thuộc bất
                                            kỳ loại nào. Những nội dung miêu tả tỉ mỉ những hành động dâm ô, bạo lực,
                                            giết người rùng rợn; đăng, phát các hình ảnh phản cảm, thiếu tính nhân văn;
                                            cung cấp nội dung, hình ảnh, tranh khỏa thân có tính chất kích dâm, thiếu
                                            thẩm mỹ, không phù hợp với thuần phong, mỹ tục Việt Nam sẽ bị cấm hoàn
                                            toàn.</p>

                                        <p>- Chúng tôi tôn trọng quyền tự do ngôn luận, nhưng cũng bảo lưu việc có toàn
                                            quyền lược bớt, hoặc xoá bỏ một phần hoặc toàn bộ các bài viết của bạn nếu
                                            xét thấy bài viết hoặc bất kỳ thông tin gì gửi lên vi phạm những điểm nêu
                                            trên, bất kể việc vi phạm đó là rõ ràng hay chỉ là hàm ý.</p>

                                        <p>- Nghiêm cấm tuyên truyền bất kỳ thông điệp nào mang tính quảng cáo, mời gọi,
                                            thư dây chuyền, cơ hội đầu tư hay bất kỳ dạng liên lạc có mục đích thương
                                            mại nào mà người dùng không mong muốn, thư rác hay tin nhắn rác, gửi hay
                                            chuyển các thông tin, phần mềm, hoặc các tài liệu khác bất kỳ, vi phạm hoặc
                                            xâm phạm các quyền của những người khác, trong đó bao gồm cả tài liệu xâm
                                            phạm đến quyền riêng tư hoặc công khai, hoặc tài liệu được bảo vệ bản quyền,
                                            tên thương mại hoặc quyền sở hữu khác, hoặc các sản phẩm phái sinh mà không
                                            được sự cho phép của người chủ sở hữu hoặc người có quyền hợp pháp. Nếu phát
                                            hiện những tài khoản vi phạm chúng tôi sẽ khóa tài khoản vĩnh viễn.</p>

                                        <p>- Bạn sẽ không gửi hoặc truyền bất kỳ thông tin hoặc phần mềm nào không thuộc
                                            quyền sở hữu của bạn trừ khi đó là phần mềm được cung cấp miễn phí. Không
                                            gửi bất kỳ thông tin hay phần mềm nào có chứa bất kỳ loại virus, Trojan, bọ
                                            hay các thành phần nguy hại nào. Không sử dụng, cung cấp thông tin vi phạm
                                            các quy định về sở hữu trí tuệ, về giao dịch thương mại điện tử và các quy
                                            định khác của pháp luật hiện hành.</p>

                                        <p>- Bạn sẽ không xâm phạm, xâm nhập, tiếp cận, sử dụng hay tìm cách xâm phạm,
                                            xâm nhập, tiếp cận hoặc sử dụng bất kỳ phần nào trong máy chủ của chúng tôi,
                                            và/ hoặc bất kỳ khu vực dữ liệu nào nếu không được chúng tôi cho phép,
                                            nghiêm cấm các hành vi lợi dụng lỗi hệ thống để trục lợi cá nhân gây thiệt
                                            hại đến nhà cung cấp dịch vụ.</p>

                                        <p>- Tuyệt đối nghiêm cấm việc gửi hoặc đăng tải thông tin, phần mềm có đính kèm
                                            virus hoặc các thành phần gây hại khác.</p>

                                        <p>- Không phá vỡ luồng thông tin bình thường trong một tương tác , tuyên bố có
                                            liên hệ hoặc đại diện cho một doanh nghiệp hoặc hiệp hội, thể chế hay tổ
                                            chức nào khác mà bạn không được uỷ quyền tuyên bố mối liên hệ đó nhằm mục
                                            đích trục lợi cá nhân gây sự nhầm lẫn đối với những thành viên cùng tham gia
                                            mạng xã hội. Bạn sẽ không được tạo ra các thông tin giả mạo cá nhân, tổ
                                            chức, doanh nghiệp khác; thông tin sai sự thật xâm hại đến quyền và lợi ích
                                            hợp pháp của tổ chức, doanh nghiệp, cá nhân.</p>

                                        <p>- Bạn không được quyền hoặc có các hành động nhằm hạn chế hoặc cấm đoán bất
                                            kỳ người dùng nào khác sử dụng và thưởng thức website mạng xã hội
                                            DJ.Pro.vn.</p>

                                        <p>- Bạn sẽ không được truyền bá tác phẩm báo chí, văn học, nghệ thuật, âm nhạc,
                                            phim ảnh, xuất bản phẩm vi phạm các quy định của pháp luật.</p>

                                        <h3>Cấm truy cập</h3>

                                        <p>Chúng tôi có toàn quyền, vào mọi lúc, cấm hoặc từ chối truy cập của bạn vào
                                            mạng xã hội DJ.Pro.vn hoặc bất kỳ phần nào của website ngay lập tức và không
                                            cần báo trước nếu chúng tôi cho rằng bạn đã vi phạm bất cứ điều khoản nào
                                            trong bản Quy định này, hoặc việc cấm truy cập xuất phát từ nhận định của
                                            chúng tôi, khi chúng tôi cho rằng từ chối đó phù hợp và cần thiết trong thẩm
                                            quyền của chúng tôi.</p>

                                        <h3>Thông tin của bên thứ ba</h3>

                                        <p>Thông tin được cung cấp tại Mạng xã hội DJ.Pro.vn có thể chứa thông tin từ
                                            bên thứ ba hoặc được các thành viên chọn lọc từ các nguồn khác. Thông tin
                                            trên mạng xã hội DJ.Pro.vn không được coi là khuyến nghị sử dụng, tiêu dùng,
                                            đầu tư v.v…, hoặc xác thực của DJ.Pro.vn về bất cứ một vấn đề, biến cố hoặc
                                            sự kiện nào và với bất kỳ mục đích nào, tương ứng với bất kỳ người, sản phẩm
                                            hoặc dịch vụ nào của 1 bên thứ ba. Mạng xã hội DJ.Pro.vn không chịu trách
                                            nhiệm nếu thông tin được các thành viên của DJ.Pro.vn đưa lên không được cập
                                            nhật theo mong muốn của bạn.</p>

                                        <h3>Liên kết đến và đi từ trang DJ.Pro.vn</h3>

                                        <p>Các liên kết tại mạng xã hội DJ.Pro.vn có thể dẫn bạn tới các website khác,
                                            và bạn thừa nhận và đồng ý rằng DJ.Pro.vn không chịu trách nhiệm về sự chính
                                            xác hoặc giá trị của bất kỳ thông tin nào do các website liên kết cung
                                            cấp.</p>

                                        <h3>Thông báo</h3>

                                        <p>DJ.Pro.vn có thể gửi các thông báo trong phạm vi Dịch vụ. DJ.Pro.vn cũng có
                                            thể gửi bạn các thông báo về những sản phẩm và Dịch vụ tới địa chỉ thư điện
                                            tử hoặc số điện thoại mà bạn đã cung cấp. Bạn được coi là đã nhận những
                                            thông báo này chậm nhất bảy (07) ngày kể từ khi DJ.Pro.vn gửi chúng. Việc
                                            bạn tiếp tục sử dụng Dịch vụ nghĩa là bạn nhận được tất cả các thông báo,
                                            không phụ thuộc vào phương thức gửi.</p>

                                        <h3>Bồi thường</h3>

                                        <p>Bạn đồng ý bảo vệ và bồi thường cho DJ.Pro.vn trước mọi khiếu nại của bên thứ
                                            ba, và mọi trách nhiệm, mức ấn định, tổn thất, chi phí hoặc thiệt hại gây ra
                                            bởi hoặc phát sinh từ việc (i) bạn vi phạm Điều Khoản, (ii) bạn vi phạm hoặc
                                            xâm phạm quyền sở hữu trí tuệ, các quyền khác hoặc quyền riêng tư bất kỳ của
                                            bên thứ ba, và (iii) bên thứ ba sử dụng sai Dịch vụ khi việc sử dụng sai đó
                                            là do bạn không thực hiện các biện pháp hợp lý để bảo vệ tên truy cập và mật
                                            khẩu của bạn để chống lại việc bị sử dụng trái phép.</p>

                                        <h3>Các điều khoản khác</h3>
                                        <h4>Căn cứ pháp luật</h4>

                                        <p>Điều Khoản sẽ được điều chỉnh bởi pháp luật Việt Nam, không bao gồm các điều
                                            khoản xung đột pháp luật.</p>
                                        <h4>Hiệu Lực</h4>

                                        <p>Điều Khoản sẽ không loại trừ hoặc giới hạn bất kỳ quyền nào của bạn mà theo
                                            pháp luật nơi bạn cư trú không thể bị từ bỏ. Nếu một quy định của Điều Khoản
                                            bị xem là vô hiệu, hiệu lực của những điều khoản còn lại sẽ không bị ảnh
                                            hưởng và điều khoản bị xem là vô hiệu sẽ được thay thế bởi một điều khoản có
                                            hiệu lực gần nhất với kết quả và mục đích của Điều Khoản. Trường hợp có mâu
                                            thuẫn giữa Điều Khoản Dịch Vụ này và Chính Sách Quyền Riêng Tư, quy định của
                                            Điều Khoản Dịch Vụ DJ.Pro.vn này sẽ được ưu tiên áp dụng. Các quy định trong
                                            Điều Khoản được ghi nhận là vẫn có hiệu lực sau khi Điều Khoản chấm dứt sẽ
                                            vẫn có hiệu lực sau sự chấm dứt này.</p>
                                        <h4>Thay đổi Điều Khoản</h4>

                                        <p>DJ.Pro.vn có thể sửa đổi Điều Khoản vào bất kỳ thời điểm nào mà không cần
                                            phải báo trước. Nếu Điều Khoản được thay đổi một cách căn bản và bất lợi,
                                            DJ.Pro.vn sẽ cung cấp một thông báo riêng về những thay đổi đó.</p>

                                        <p>Bạn có trách nhiệm xem xét các Điều Khoản một cách thường xuyên. Việc tiếp
                                            tục sử dụng Dịch vụ của bạn được xem là sự đồng ý của bạn đối với các thay
                                            đổi và sửa đổi.</p>

                                        <h3>Sở hữu trí tuệ</h3>

                                        <p>Dịch vụ và các phần mềm liên quan được bảo vệ bởi luật bản quyền Việt Nam và
                                            quốc tế bạn đồng ý và tuân thủ theo quy định của pháp luật. Căn cứ vào các
                                            Điều Khoản, DJ.Pro.vn bảo lưu tất cả các quyền, quyền sở hữu và lợi ích
                                            trong Dịch vụ và tất cả sản phẩm, phần mềm và các tài sản khác được cung cấp
                                            cho bạn hoặc sử dụng bởi bạn thông qua Dịch vụ.</p>

                                        <h3>Chuyển nhượng</h3>

                                        <p>DJ.Pro.vn có thể chuyển nhượng các quyền và nghĩa vụ trong Điều Khoản này cho
                                            bất kỳ công ty mẹ, chi nhánh của công ty TNHH Truyền Thông TECHNOLOGY Việt
                                            Nam hoặc công ty dưới quyền kiểm soát chung với DJ.Pro.vn. Ngoài ra,
                                            DJ.Pro.vn có thể chuyển nhượng các quyền và nghĩa vụ trong Điều Khoản này
                                            cho bên thứ ba trong quá trình sáp nhập, mua lại, bán tài sản, theo quy định
                                            của pháp luật hoặc trong các trường hợp khác.</p>

                                        <h3>CHÍNH SÁCH BẢO MẬT</h3>

                                        <p>Khi truy cập vào diễn đàn DJ.Pro.vn tại trang web: www. DJ.Pro.vn và bất kì
                                            trang nào từ đây, hãy ghi nhớ và đồng ý rằng chúng tôi sẽ thu thập thông tin
                                            cá nhận của bạn theo những điều khoản trong Chính Sách bảo mật và Điều khoản
                                            sử dụng. Cứ mỗi lần truy cập vào trang web này hay sử dụng địa chỉ e-mail
                                            hoặc số điện thoại được cung cấp trên trang web, hãy ghi nhớ và chấp thuận
                                            về việc chúng tôi có quyền sử dụng thông tin cá nhân của người sử dụng như
                                            đã đề cập trong Chính sách bảo mật. Vui lòng không truy cập vào trang web và
                                            không gửi bất kì thông tin cá nhân nào của mình nếu không muốn chúng tôi lưu
                                            trữ hay sử dụng những dữ liệu này như đã đề cập.</p>

                                        <p>DJ.Pro.vn có quyền thay đổi hay chỉnh sửa Chính sách bảo mật này bất kì lúc
                                            nào. Thông tin dữ liệu của bạn sẽ được quản lí dựa theo Chính sách bảo mật
                                            và chúng tôi sẽ cập nhật lên trang web của mình nếu có sự thay đổi trong
                                            Chính sách. Cứ mỗi lần truy cập vào trang web sau khi những chỉnh sửa có
                                            hiệu lực, đồng nghĩa bạn đã chấp nhận với Chính sách bảo mật sửa đổi này.
                                            Vui lòng vào đọc những thông tin mới nhất về Chính sách bảo mật và hãy chắc
                                            chắn rằng bạn hiểu rõ nó. Ngày cập nhật những thay đổi thông tin trong Chính
                                            sách bảo mật của chúng tôi đều được ghi rõ ở cuối trang. DJ.Pro.vn luôn cam
                                            kết sẽ tôn trọng và bảo vệ sự riêng tư của bạn. Chính sách của chúng tôi
                                            liên quan đến toàn bộ các thông tin dữ liệu trực tuyến khác nhau trên trang
                                            web của DJ.Pro.vn và mô tả cách mà dữ liệu cá nhân được thu thập và sử dụng
                                            và tuân thủ luật pháp hiện hành.</p>

                                        <h3>Sử dụng cookies</h3>

                                        <p>DJ.Pro.vn sử dụng hệ thống theo dõi như cookies để tập hợp thông tin kết nối
                                            và đánh giá thông tin hoạt động người dùng trang web. Mỗi cookie là một
                                            thành phần của dữ liệu mà một trang web có thể gửi đến trình duyệt web máy
                                            tính để máy tính này có thể được nhận biết sau khi quay lại website này.
                                            Cookies cho phép web máy chủ nhận ra máy tính của bạn khi kết nối đến trang
                                            web và làm cho tốc độ truy cập vào trang web sẽ nhanh hơn so với lần đầu.
                                            Cookies cũng có thể được sử dụng để tạo thống kê hoạt động của trang web
                                            bằng cách tập hợp và phân tích các cơ sở dữ liệu khác nhau (ví dụ như những
                                            trang được xem nhiều nhất, thời gian người dùng lưu lại trên trang web v.v).
                                            Chúng tôi sẽ không dùng cookies để giám sát những lần ghé thăm vào trang web
                                            của từng cá nhân cụ thể. Ngoài ra, cookies không được sử dụng cho những mục
                                            đích khác. Bên cạnh đó, bạn cũng có thể cài đặt thông báo trên trình duyệt
                                            khi cookie được lưu trữ vào ổ cứng máy tính. Trong trường hợp bạn không muốn
                                            lưu trữ cookie, trình duyệt web vẫn có thể cài đặt chức năng này. Tuy nhiên,
                                            để tối ưu hóa trải nghiệm sử dụng, chúng tôi đề nghị bạn không khóa chức
                                            năng lưu trữ cookie. Quá trình từ chối nhận cookie vào máy tính phụ thuộc
                                            nhà cung cấp dịch vụ phần mềm. Vui lòng liên hệ với nhà cung cấp phần mềm
                                            của bạn nếu muốn từ chối nhận cookie. Trong vài trường hợp, bạn sẽ không thể
                                            sử dụng một số chức năng nhất định trên trang web nếu cookie đã bị chặn.</p>

                                        <h3>Phạm vi sử dụng thông tin của bạn?</h3>

                                        <p>Chúng tôi sử dụng thông tin người dùng trang web của DJ.Pro.vn trong phạm vi
                                            như sau:</p>

                                        <p>- Tên<br/>- Số điện thoại<br/>- Địa chỉ email</p>

                                        <p>Chúng tôi sẽ sử dụng những thông tin kết nối cho mục đích thống kê, quản lí
                                            và cải thiện năng suất cho trang web bằng những phần mềm công cụ (ví dụ
                                            Google analytics) hay cookies ( xem mục đích sử dụng cookies).</p>

                                        <p>Chúng tôi sử dụng thông tin liên lạc của bạn (i) để trả lời những thắc mắc mà
                                            bạn có về trang web cũng như báo cho bạn biết nếu có bất kì thay đổi nào
                                            trên trang web; (ii) cung cấp cho bạn những thông tin bạn yêu cầu ( có trong
                                            chức năng đăng kí); (iii) thông báo cho bạn biết những hoạt động cũng như sự
                                            kiện khác nhau của DJ.Pro.vn.</p>

                                        <p>Chúng tôi sử dụng thông tin liên lạc của bạn để tiện việc thông báo về những
                                            chương trình mà bạn có thể có hứng thú (thông tin quảng cáo, khuyến mãi),
                                            trừ khi bạn thông báo với chúng tôi rằng bạn không muốn nhận những thông tin
                                            khuyến mãi từ DJ.Pro.vn.</p>

                                        <p>Chúng tôi cũng lấy những ý kiến của bạn trong chức năng bình luận từ trang
                                            web hay làm những bản báo cáo, thống kê và khảo sát dấu tên từ dữ liệu mà
                                            bạn cung cấp trên trang chủ. Tất cả những ý kiến trên website sẽ được hiển
                                            thị dưới dạng giấu tên trừ khi bạn hoàn toàn đồng ý cho thông tin cá nhân
                                            của mình được công khai.</p>

                                        <h3>Tiết lộ thông tin cho bên thứ ba</h3>

                                        <p>Chúng tôi sẽ không tiết lộ thông tin cá nhân của bạn cho bên thứ ba, trừ
                                            những trường hợp sau: (1) theo yêu cầu của luật pháp hay lệnh từ tòa án; (2)
                                            bên cung cấp dịch vụ hỗ trợ DJ.Pro.vn xử lí thông tin hoặc tương tự; (3) tái
                                            cơ cấu, thanh lí hay sát nhập doanh nghiệp; (4) để bảo vệ quyền lợi cần
                                            thiết của DJ.Pro.vn và của những người dùng khác.</p>

                                        <h3>Lưu trữ e-mail</h3>

                                        <p>Tất cả những e-mail nhận và gửi đều được bảo vệ bởi tính pháp lý, kĩ thuật và
                                            trong phạm vi của tổ chức. Những dữ liệu này chỉ được truy cập trong những
                                            trường hợp rất đặc biệt theo luật hiện hành (ví dụ lệnh của tòa, điều tra
                                            tình nghi tội phạm, vi phạm luật pháp hay vi phạm luật lao động). Truy cập
                                            chỉ được cấp cho nhân viên và các chức năng truy cập cũng bị giới hạn (ví dụ
                                            luật pháp, kiện tụng, rủi ro). Qui trình thực hiện cũng như tiêu chí tìm
                                            kiếm đã được xác định trước. Tất cả các e-mail sẽ được xóa hết sau một
                                            khoảng thời gian ngắn. Nếu bạn không muốn DJ.Pro.vn lưu trữ những e-mail cá
                                            nhân của mình, chúng tôi khuyến cáo bạn không nên gửi e-mail mang mục đích
                                            cá nhân hay không liên quan đến công việc vào hộp thư của DJ.Pro.vn.</p>

                                        <h3>An ninh và bảo mật dữ liệu</h3>

                                        <p>DJ.Pro.vn áp dụng và đảm bảo rằng các nhà cung cấp dịch vụ ứng dụng các biện
                                            pháp kĩ thuật và an ninh tổ chức phù hợp để bảo vệ dữ liệu cá nhân chống lại
                                            sự phá hủy vô tình, phạm pháp, mất mát, tiết lộ trái phép hay xâm phạm với
                                            các hình thức bất hợp pháp khác.</p>

                                        <p>Việc truy cập và nhập liệu thông tin trên trang web của DJ.Pro.vn được thực
                                            hiện bởi người dùng qua mạng internet, một mạng lưới kết nối mở và không an
                                            toàn. Cơ sở dữ liệu này thường được trao đổi theo dạng không mã hóa. Do đó,
                                            chúng tôi không thể đảm bảo tính bảo mật thông tin của bạn khi nó được tải
                                            vào trang web. Bạn xác nhận rằng bạn nhận thức được những rủi ro gặp phải
                                            khi truyền tải dữ liệu qua lại dưới dạng không mã hóa qua Internet.
                                            DJ.Pro.vn sẽ không chịu trách nhiệm cho bất kì thiệt hại nào gây ra trong
                                            quá trình truyền tải dữ liệu. Vì vậy, vui lòng không gửi cho chúng tôi bất
                                            kì thông tin cá nhân mang tính tuyệt mật hay nhạy cảm.</p>

                                        <h3>Dữ liệu thông tin của bạn được lưu trữ bao lâu?</h3>

                                        <p>DJ.Pro.vn lưu trữ thông tin cá nhân thu thập được qua trang web trong thời
                                            gian 2 năm. Người dùng có thể yêu cầu chỉnh sửa hoặc xóa bỏ thông tin qua
                                            mục Liên hệ tại website http://DJ.Pro.vn.</p>

                                        <h3>Đường dẫn đến những trang web bên ngoài</h3>

                                        <p>Từ trang web của DJ.Pro.vn bạn có thể truy cập vào các trang web của bên thứ
                                            ba. Chính sách bảo mật này không áp dung cho những trang web bên ngoài.
                                            Những trang web này không được quản lí và duy trì bởi DJ.Pro.vn. Chúng tôi
                                            không chịu trách nhiệm về Chính sách bảo mật cho bất kì trang web khác. Vui
                                            lòng xem Chính sách bảo mật của từng trang web đó trước khi truy cập hay gửi
                                            thông tin cá nhân của mình vào.</p>

                                        <h3>Cách truy cập vào thông tin của bạn</h3>

                                        <p>Bạn được quyền yêu cầu một bản sao về những thông tin cá nhân của mình đã
                                            được thu thập và lưu trữ trên trang web của DJ.Pro.vn. Bạn cũng có thể yêu
                                            cầu chỉnh sửa hay xóa bỏ thông tin của mình theo luật pháp hiện hành qua mục
                                            Liên hệ trên trang web http://DJ.Pro.vn.</p>

                                        <h3>Địa chỉ liên hệ</h3>

                                        <p>Nếu bạn có bất kì câu hỏi nào liên quan đến quá trình xử lí thông tin của bạn
                                            hay Chính sách bảo mật này, vui lòng liên hệ với chúng tôi qua số điện thoại
                                            trên trang chủ của trang web hoặc tại địa chỉ: Lầu 1 - Phường 2 - Quận 3 -
                                            Thành Phố 4 - Việt Nam </p>

                                        <p class="center"><b>Quy chế này có thể sửa đồi tùy theo từng thời điểm và tình
                                                hình chung của trang mạng xã hội. Quy chế có hiệu lực từ ngày đăng thông
                                                báo.</b></p>
                                    </div>
                                </div>

                                <ul class="other-news-detail">
                                    <h2><span>Tin khác</span></h2>
                                    <li><span><a href="/chinh-sach-rieng-tu.html" title="">Chính sách riêng
                                                tư</a></span></li>
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
            <?php $v177172153694398248391iterator = $listCategory_footer; $v177172153694398248391incr = 0; $v177172153694398248391loop = new stdClass(); $v177172153694398248391loop->length = count($v177172153694398248391iterator); $v177172153694398248391loop->index = 1; $v177172153694398248391loop->index0 = 1; $v177172153694398248391loop->revindex = $v177172153694398248391loop->length; $v177172153694398248391loop->revindex0 = $v177172153694398248391loop->length - 1; ?><?php foreach ($v177172153694398248391iterator as $index => $itemFooterMenu) { ?><?php $v177172153694398248391loop->first = ($v177172153694398248391incr == 0); $v177172153694398248391loop->index = $v177172153694398248391incr + 1; $v177172153694398248391loop->index0 = $v177172153694398248391incr; $v177172153694398248391loop->revindex = $v177172153694398248391loop->length - $v177172153694398248391incr; $v177172153694398248391loop->revindex0 = $v177172153694398248391loop->length - ($v177172153694398248391incr + 1); $v177172153694398248391loop->last = ($v177172153694398248391incr == ($v177172153694398248391loop->length - 1)); ?>
                <?php if ($index % 5 == 0) { ?>
                    <div class="col-md-2 col-sm-3 col-xs-6">
                    <ul class="list1">
                <?php } ?>
                <li><a href="<?php echo $itemFooterMenu['link']; ?>"><?php echo $itemFooterMenu['title']; ?></a></li>
                <?php if ($index % 5 == 4 || $v177172153694398248391loop->last) { ?>
                    </ul>
                    </div>
                <?php } ?>
            <?php $v177172153694398248391incr++; } ?>

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




<script type="text/javascript" src="js/cbpFWTabs.js"></script>
<script type="text/javascript">
    (function () {

        [].slice.call(document.querySelectorAll('.tabs')).forEach(function (el) {
            new CBPFWTabs(el);
        });

    })();
</script>
