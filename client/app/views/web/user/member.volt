{% include '/layouts/header.volt' %}

<div id="content">
    <div class="artists">
        <div class="container">
            <div class="row">
                <div class="col-ldh-9 col-sm-8">
                    <div class="tabs tabs-style-linemove">
                        <nav>
                            <ul>
                                <li class="tab-current"><a href="{{ uinfo.link }}"
                                                           class="icon icon-all"><span>Tất cả</span></a></li>
                                <li class=""><a href="{{ uinfo.link }}?t=audio" class="icon icon-baihat"><span>Bài hát đã đăng</span></a>
                                </li>
                                <li class=""><a href="{{ uinfo.link }}?t=playlist"
                                                class="icon icon-playlist"><span>Playlist đã đăng</span></a></li>
                                <li class=""><a href="{{ uinfo.link }}?t=video"
                                                class="icon icon-video"><span>Video đã đăng</span></a></li>
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-linemove-1" class="content-current">
                                <div class="td_heading">
                                    <h2>
                                        <span class="while"><a href="{{ uinfo.link }}?t=audio">Bài hát</a> (<span id="clkeyword">{{ countaudio }}</span>)<i class="fa fa-angle-right"></i></span>
                                    </h2>
                                </div>
                                {% if listmedia %}
                                    <div data-special-type="app">
                                        <ul class="listtop">
                                            {% for key,item in listmedia %}
                                                <li><a href="{{ item['link'] }}"><span>{{ key+1 }}
                                                            . </span>{{ item['name'] }}</a></li>
                                            {% endfor %}
                                        </ul>
                                    </div>
                                {% else %}
                                    <p>Chưa cập nhật!</p>
                                {% endif %}
                                <div class="td_heading"><h2><span class="while"><a href="{{ uinfo.link }}?t=playlist">Playlist</a> (<span id="clkeyword">{{ countplaylist }}</span>) <i class="fa fa-angle-right"></i></span></h2></div>
                                {% if listplaylist %}
                                    <div class="row">
                                        {% for item in listplaylist %}
                                            <div class="col-md-3 col-sm-4 col-xs-6">
                                                <div class="block-music">
                                                    <div class="cover-outer-align">
                                                        <a href="{{ item['link'] }}" title="{{ item['name'] }}">
                                                            <img class="cover-image" src="{{ item['priavatar'] }}"
                                                                 alt=""/>
                                                        </a>
                                               <span class="icon-circle-play">
                                                   <a class="button" href="{{ item['link'] }}" title=""><i
                                                               class="fa fa-play"></i></a>
                                               </span>
                                                    </div>

                                                    <div class="details">
                                                        <h3><a class="title" href="{{ item['link'] }}"
                                                               title="">{{ item['name'] }}
                                                                <span class="paragraph-end"></span></a></h3>

                                                        {% include "/layouts/listartist.volt" %}
                                                    </div>
                                                </div>
                                            </div>
                                        {% endfor %}
                                    </div>
                                {% else %}
                                    <p>Chưa cập nhật!</p>
                                {% endif %}
                                <div class="td_heading"><h2><span class="while"><a href="{{ uinfo.link }}?t=video">Video</a> (<span id="clkeyword">{{ countvideo }}</span>)<i
                                                    class="fa fa-angle-right"></i></span></h2></div>
                                {% if listvideo %}
                                    <div class="row">
                                        {% for item in listvideo %}
                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                <div class="block-music">
                                                    <div class="cover-outer-align">
                                                        <a href="{{ item['link'] }}" title="{{ item['name'] }}">
                                                            <img class="img-responsive" src="{{ item['priavatar'] }}"
                                                                 alt=""/>
                                                        </a>
                                           <span class="icon-circle-play"> 
                                               <a class="button" href="{{ item['link'] }}" title=""><i
                                                           class="fa fa-play"></i></a>
                                           </span>
                                                        <a href="{{ item['link'] }}" title="{{ item['name'] }}">
                                                            <div class="video-item-info">
                                                        <span class="video-item-view"><span
                                                                    class="fa fa-eye"></span> {{ item['view'] }}</span>
                                                        <span class="video-item-like"><span
                                                                    class="fa fa-clock-o"></span> {{ item['duration'] }}</span>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="details">
                                                        <h3><a href="{{ item['link'] }}" class="title tooltip-top"
                                                               title="{{ item['name'] }}">{{ item['name'] }}
                                                                <span class="paragraph-end"></span></a></h3>

                                                        {% include "/layouts/listartist.volt" %}
                                                    </div>
                                                </div>
                                            </div>
                                        {% endfor %}
                                    </div>
                                {% else %}
                                    <p>Chưa cập nhật!</p>
                                {% endif %}
                            </section>
                        </div>
                        <!-- /content -->
                    </div>
                    <!-- /tabs -->
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="shadow">
                        <div class="img-center">
                            <img src="{{ uinfo.priavatar }}" alt=""/>
                        </div>
                        <div class="summary">
                            <h2 class="title_user">Xin chào:
                                <a href="{{ uinfo.link }}" title="{{ uinfo.username }}" style="{% if uinfo.is_role ==1 %} color: #c73030;{% else %} color: #176093;{% endif %}">{{ uinfo.username }}</a>
                                <span class="role_user">{{ uinfo.namerole }}</span>
                            </h2>
                            <ul class="menuSub">
                                <li><i class="fa fa-user"></i> Họ tên: {{ uinfo.fullname }}</li>
                                <li><i class="fa fa-birthday-cake"></i> Ngày sinh: {{ uinfo.days }}/{{ uinfo.month }}/{{ uinfo.year }}</li>
                                <li><i class="fa fa-smile-o"></i> Giới tính:  {{ uinfo.sex }} </li>
                                <li><i class="fa fa-facebook"></i> Facebook: {{ uinfo.facebook }}</li>
                                <li><i class="fa fa-yahoo"></i> Yahoo! Messenger: {{ uinfo.yahoo }}</li>
                                <li><i class="fa fa-skype"></i> Skype: {{ uinfo.skype }}</li>
                                <li><i class="fa fa-phone"></i> SĐT: {{ uinfo.phone }}</li>
                                <li><i class="fa fa-bank"></i> Địa chỉ: {{ uinfo.address }}</li>
                                <li><i class="fa fa-briefcase"></i> Nghề nghiệp: {{ uinfo.job }}</li>
                                <li><i class="fa fa-gamepad"></i> Sở thích: {{ uinfo.hobby }}</li>
                                <li><h2 class="title_user"></h2></li>
                                <li><h2 >Thống kê</h2></li>
                                <li><i class="fa fa-cloud-upload"></i> Số bài đã đăng: {{ uinfo.totalmedia }}</li>
                                <li><i class="fa fa-thumbs-o-up"></i> Số lần được Like: {{ uinfo.totallikemedia }}</li>
                                <li><i class="fa fa-thumbs-o-down"></i> Số lần Dislike: {{ uinfo.totaldislikemedia }}</li>
                                <li><i class="fa fa-comment"></i> Tổng số bình luận: {{ uinfo.totalcomment }}</li>
                                <li><i class="fa fa-frown-o"></i> Hoạt động gần nhất: {{ uinfo.timeactivity }}</li>
                                <li><i class="fa fa-user"></i> Trạng thái: {% if uinfo.isonline == 1 %} Online {% else %} Offline {% endif %}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!--===================footer=====================-->
{% include '/layouts/footer.volt' %}
