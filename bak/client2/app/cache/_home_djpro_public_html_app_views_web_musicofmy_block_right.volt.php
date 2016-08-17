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