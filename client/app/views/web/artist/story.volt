{#<script type="text/javascript" src="/web/js/cbpFWTabs.js"></script>#}
{% include "/layouts/header.volt" %}
<div id="content">

    <div class="banner-gs">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/nghe-sy.html">Nghệ sỹ</a></li>
                {% for item in listcategory %}
                    <li><a href="{{ item['link'] }}">{{ item['name'] }}</a></li>
                {% endfor %}
                <li><a href="{{ object.link }}">{{ object.username }}</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="divpre">
                <img height="350" src="{{ object.banner }}" alt="{{ object.username }}">

                <div class="box-info-artist">
                    <div class="info-artist fluid">

                        <img height="150" src="{{ object.priavatar }}" alt="{{ object.username }}">

                        <div class="info-summary">
                            <div class="info-summary-title"><a href="{{ object.link }}" title="{{ object.username }}" alt="{{ object.username }}"><h1>{{ object.username }}</h1></a> </div>
                            {% if object.description %}
                                <p>{{ object.description }} <a href="{{ object.link }}?t=info">Tiểu
                                        sử {{ object.username }}</a></p>
                            {% endif %}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="artists">
        <div class="container">
            <div class="row">
                <div class="col-ldh-9 col-sm-8">
                    <div class="tabs tabs-style-iconbox">
                        <nav>
                            <ul>
                                <li class="tabs_artist "><a href="{{ object.link }}"
                                                            class="icon icon-all"><span>Tất cả</span></a>
                                </li>
                                <li class="tabs_artist"><a href="{{ object.link }}?t=audio"
                                                           class="icon icon-baihat"><span>Bài hát đã đăng</span></a>
                                </li>
                                <li class="tabs_artist"><a href="{{ object.link }}?t=album"
                                                           class="icon icon-album"><span>Album đã đăng</span></a></li>
                                <li class="tabs_artist"><a href="{{ object.link }}?t=video"
                                                           class="icon icon-video"><span>Video đã đăng</span></a></li>
                                <li class="tabs_artist tab-current" id="story"><a class="icon icon-tieusu"
                                                                                  href="{{ object.link }}?t=info"><span>Tiểu sử</span></a>
                                </li>
                            </ul>
                        </nav>
                        <div class="content-wrap" id="block_story">
                            <div class="td_heading"><h2><span class="while">Tiểu sử <i
                                                class="fa fa-angle-right"></i></span>
                                </h2></div>

                            <div class="row">
                                <div class="col-md-3 col-xs-5 col-sm-5">
                                    <i class="fa fa-user"></i> Nghệ danh:
                                </div>
                                <div class="col-md-9 col-xs-7 col-sm-7">
                                    {{ object.username }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-5 col-sm-5" >
                                    <i class="fa fa-user"></i> Tên thật:
                                </div>
                                <div class="col-md-9 col-xs-7 col-sm-7">
                                    {{ object.realname }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-5 col-sm-5">
                                    <i class="fa fa-suitcase"></i> Chức vụ:
                                </div>
                                <div class="col-md-9 col-xs-7 col-sm-7">
                                    {% if object.type is defined %}
                                        {% for item in object.type %}
                                            {{ artisttype[item] }}{% if !loop.last %}, {% endif %}
                                        {% endfor %}
                                    {% else %}
                                        Đang cập nhật
                                    {% endif %}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-5 col-sm-5">
                                    <i class="fa fa-globe"></i> Quốc gia:
                                </div>
                                <div class="col-md-9 col-xs-7 col-sm-7">
                                    {% if listCate is defined %}
                                        {% for item in listCate %}
                                            {{ item['name'] }}{% if !loop.last %}, {% endif %}
                                        {% endfor %}
                                    {% else %}
                                        Đang cập nhật
                                    {% endif %}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-5 col-sm-5">
                                    <i class="fa fa-map-marker"></i> Đến từ:
                                </div>
                                <div class="col-md-9 col-xs-7 col-sm-7">
                                    {{ object.from }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-5 col-sm-5">
                                    <i class="fa fa-birthday-cake"></i> Ngày sinh:
                                </div>
                                <div class="col-md-9 col-xs-7 col-sm-7">
                                    {{ object.birthday }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-5 col-sm-5">
                                    <i class="fa fa-smile-o"></i> Giới tính:
                                </div>
                                <div class="col-md-9 col-xs-7 col-sm-7">
                                   {{ object.sex }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-5 col-sm-5">
                                    <i class="fa fa-briefcase"></i> Nghề nghiệp:
                                </div>
                                <div class="col-md-9 col-xs-7 col-sm-7">
                                    {{ object.job }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-5 col-sm-5">
                                    <i class="fa fa-music"></i> Dòng nhạc chơi:
                                </div>
                                <div class="col-md-9 col-xs-7 col-sm-7">
                                    {{ object.playmusic }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-5 col-sm-5">
                                    <i class="fa fa-calendar"></i> Năm vào nghề:
                                </div>
                                <div class="col-md-9 col-xs-7 col-sm-7">
                                    {{ object.yearjob }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-5 col-sm-5">
                                    <i class="fa fa-archive"></i> Club đã làm:
                                </div>
                                <div class="col-md-9 col-xs-7 col-sm-7">
                                    {{ object.clubdid }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-5 col-sm-5">
                                    <i class="fa fa-home"></i> Đang làm việc tại:
                                </div>
                                <div class="col-md-9 col-xs-7 col-sm-7">
                                    {{ object.workingat }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-5 col-sm-5">
                                    <i class="fa fa-gamepad"></i> Sở thích:
                                </div>
                                <div class="col-md-9 col-xs-7 col-sm-7">
                                    {{ object.hobby }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-5 col-sm-5">
                                    <i class="fa fa-facebook"></i> Facebook:
                                </div>
                                <div class="col-md-9 col-xs-7 col-sm-7">
                                    {{ object.facebook }}
                                </div>
                            </div>
                            <div class="row">
                                {% if object.content %}
                                    <div class="col-md-12">
                                        {{ object.content }}
                                    </div>
                                {% endif %}
                            </div>
                            </section>
                        </div>
                        <!-- /content -->
                    </div>
                    <!-- /tabs -->
                </div>

                <div class="col-ldh-3 col-sm-4">
                    <div class="sidebar">
                        <h2 class="heading">NGHỆ SĨ TƯƠNG TỰ</h2>

                        <ul class="dsartist">
                            {% for item in listartist %}
                                <li>
                                    <a href="{{ item['link'] }}" title="{{ item['username'] }}" class="thumb pull-left">
                                        <img src="{{ item['priavatar'] }}" alt="{{ item['username'] }}">
                                    </a>

                                    <h3 class="song-name">
                                        <a href="{{ item['link'] }}" title="{{ item['username'] }}"
                                           class="txt-primary">{{ item['username'] }}</a></h3>

                                    {#<div class="singer-name">1,340 quan tâm</div>#}
                                    <a href="{{ item['link'] }}"><i class="button-follow fa fa-plus"></i></a>
                                </li>
                            {% endfor %}

                        </ul>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
{% include "/layouts/footer.volt" %}