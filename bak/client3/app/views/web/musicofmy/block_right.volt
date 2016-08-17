<h2 class="title_user">Xin chào:
    <a href="{{ uinfo['link'] }}" title="{{ uinfo['username'] }}" style="{% if uinfo['is_role'] ==1 %} color: #c73030;{% else %} color: #176093;{% endif %}">{{ uinfo['username'] }}</a>
    <span class="role_user">{{ uinfo['namerole'] }}</span>
</h2>
<ul class="menuSub">
    <li><i class="fa fa-user"></i> Họ tên: {{ uinfo['fullname'] }}</li>
    <li><i class="fa fa-birthday-cake"></i> Ngày sinh: {{ uinfo['birthday'] }}</li>
    <li><i class="fa fa-smile-o"></i> Giới tính:  {{ uinfo['sex'] }} </li>
    <li><i class="fa fa-facebook"></i> Facebook: {{ uinfo['facebook'] }}</li>
    <li><i class="fa fa-yahoo"></i> Yahoo! Messenger: {{ uinfo['yahoo'] }}</li>
    <li><i class="fa fa-skype"></i> Skype: {{ uinfo['skype'] }}</li>
    <li><i class="fa fa-phone"></i> SĐT: {{ uinfo['phone'] }}</li>
    <li><i class="fa fa-bank"></i> Địa chỉ: {{ uinfo['address'] }}</li>
    <li><i class="fa fa-briefcase"></i> Nghề nghiệp: {{ uinfo['job'] }}</li>
    <li><i class="fa fa-gamepad"></i> Sở thích: {{ uinfo['hobby'] }}</li>
    <li><h2 class="title_user"></h2></li>
    <li><h2 >Thống kê</h2></li>
    <li><i class="fa fa-cloud-upload"></i> Số bài đã đăng: {{ uinfo['totalmedia'] }}</li>
    <li><i class="fa fa-thumbs-o-up"></i> Số lần được Like: {{ uinfo['totallikemedia'] }}</li>
    <li><i class="fa fa-thumbs-o-down"></i> Số lần Dislike: {{ uinfo['totaldislikemedia'] }}</li>
    <li><i class="fa fa-comment"></i> Tổng số bình luận: {{ uinfo['totalcomment'] }}</li>
    <li><i class="fa fa-frown-o"></i> Hoạt động gần nhất: {{ uinfo['timeactivity'] }}</li>
    <li><i class="fa fa-user"></i> Trạng thái: {% if uinfo['isonline'] == 1 %} Online {% else %} Offline {% endif %}</li>
</ul>