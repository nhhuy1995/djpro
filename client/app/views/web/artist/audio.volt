{#<script type="text/javascript" src="/web/js/cbpFWTabs.js"></script>#}
{% include "/layouts/header.volt" %}
<div id="content">

    <div class="banner-gs">
        <div class="container">
            {% include "/layouts/breadcrumb.volt" %}
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
                                <p>{{ object.description }} <a href="{{ object.link }}?t=info">Tiểu sử {{ object.username }}</a></p>
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
                                <li class="tabs_artist tab-current"><a href="{{ object.link }}?t=audio" class="icon icon-baihat"><span>Bài hát đã đăng</span></a>
                                </li>
                                <li class="tabs_artist"><a href="{{ object.link }}?t=album"
                                                           class="icon icon-album"><span>Album đã đăng</span></a></li>
                                <li class="tabs_artist"><a href="{{ object.link }}?t=video"
                                                           class="icon icon-video"><span>Video đã đăng</span></a></li>
                                <li class="tabs_artist" id="story"><a class="icon icon-tieusu" href="{{ object.link }}?t=info"><span>Tiểu sử</span></a>
                                </li>
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-linemove-2" style="display: block">
                                <div class="td_heading"><h2><span class="while">Bài hát<i class="fa fa-angle-right"></i></span>
                                    </h2></div>
                                {% include '/layouts/cothebanmuonnghe.volt' %}
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