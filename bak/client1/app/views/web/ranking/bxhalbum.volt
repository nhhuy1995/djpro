<link rel="stylesheet" href="/web/skins/charts.css"/>
{% include "layouts/header.volt" %}
{% if session['_id'] %}
    {% set clparent = '' %}
    {% set clchildren = '' %}
{% else %}
    {% set clparent = 'main-nav' %}
    {% set clchildren = 'cd-signin' %}
{% endif %}
<div id="content">

    <div class="bg-BXH">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/trang-chu.html"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/bxh.html">Bảng xếp hạng</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="row">

                <div class="col-ldh-9 col-sm-8">

                    <div class="td_heading">
                        <h2>
                            <span class="while">Bảng xếp hạng<i class="fa fa-angle-right"></i></span></h2>
                    </div>

                    <div class="tabs tabs-style-iconbox">
                        <nav>
                            <ul>
                                <li class=""><a href="/bxh.html" class="icon icon-baihat"><span>Bài hát</span></a>
                                </li>
                                <li class=""><a href="/bxh.html?t=video"
                                                class="icon icon-video"><span>Video</span></a></li>
                                    <li class="{% if _GET['t'] == 'topic' %} tab-current {% endif %}"><a href="/bxh.html?t=topic"
                                                    class="icon icon-chude"><span>Chủ đề</span></a></li>
                                    <li class="{% if _GET['t'] == 'album' %} tab-current {% endif %}"><a href="/bxh.html?t=album"
                                                    class="icon icon-album"><span>Album</span></a></li>
                                    <li class="{% if _GET['t'] == 'playlist' %} tab-current {% endif %}"><a href="/bxh.html?t=playlist"
                                                    class="icon icon-playlist"><span>Playlist</span></a></li>
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-linemove-4" class="content-current">
                                {% for key,item in listAlbum %}
                                {% set cl = 'secondary-visible' %}
                                {% if key == 0 %} {% set cl = 'row-new secondary-visible' %} {% endif %}
                                <article class="chart-row {{ cl }}">
                                    <div class="row-primary">
                                        {% if item['increase'] is not defined %}
                                            <div class="row-history row-history-new"></div>
                                            <div class="row-award-indicator"><i class="fa fa-star"></i></div>
                                            <div class="row-new-indicator">Mới</div>
                                        {% elseif item['increase'] >=0 %}
                                            <div class="row-history row-history-rising"></div>
                                            <div class="row-award-indicator"><i class="fa fa-star"></i></div>
                                        {% else %}
                                            <div class="row-history row-history-falling"></div>
                                        {% endif %}
                                        <div class="row-bullet"><i class="fa fa-dot-circle-o"></i></div>
                                        <div class="row-rank">
                                            <span class="this-week">{{ key+1 }}</span>
                                                <span class="last-week">
                                                    Tuần trước: {% if item['increase'] is not defined %} -- {% else %} {{ item['last_week'] }} {% endif %}
                                                </span>
                                        </div>
                                        <div class="row-image"><a href="{{ item['link'] }}"
                                                                  title="{{ item['name'] }}"><img
                                                        src="{{ item['priavatar'] }}" alt="{{ item['name'] }}"/></a>
                                        </div>
                                        <div class="row-title">
                                            <a href="{{ item['link'] }}" class="title_audio" title="{{ item['name'] }}">
                                                <h2>{{ item['name'] }}</h2>
                                            </a>

                                            <h3>
                                                {% if item['artist'] %}
                                                {% for itemchild in item['artist'] %}
                                                <a href="{{ itemchild['link'] }}"
                                                   title="{{ itemchild['username'] }}">{{ itemchild['username'] }}</a>
                                                {% if !loop.last %}<span
                                                        style="font-weight: normal;">ft</span>{% endif %}
                                                    {% endfor %}
                                                {% endif %}
                                            </h3>
                                            <span><i class="fa fa-headphones"></i> {{ item['view'] }}</span>
                                        </div>
                                        <div class="streaming-player-wrap">
                                            <div class="streaming-player row-player">
                                                <a href="{{ item['link'] }}" class="streaming-player-play"><i
                                                            class="fa fa-play"></i></a>
                                            </div>
                                        </div>
                                        <div class="row-watch">
                                            <span class="{{ clparent }}">
                                                <a class="tooltip-top {{ clchildren }}" data-original-title="Thêm vào"
                                                   href="javascript:void(0)"
                                                        {% if session['_id'] %}
                                                            onclick="showFormAddPlaylist({{ item['_id'] }})"
                                                        {% endif %}
                                                        >
                                                    <i class="fa fa-plus"></i></a>
                                            </span>
                                        </div>
                                        <div class="row-secondary-toggle"><a href="#"><i
                                                        class="fa fa-angle-down"></i></a></div>
                                    </div>

                                    <div class="row-secondary">
                                        <div class="stats">
                                            <div class="stats-last-week">
                                                <span class="label">Tuần trước</span>
                                                    <span class="value">
                                                      {% if item['increase'] is not defined %} -- {% else %} {{ item['last_week'] }} {% endif %}
                                                    </span>
                                            </div>
                                            <div class="stats-top-spot">
                                                <span class="label">Vị trí cao nhất</span>
                                                <span class="value">{{ item['highest']+1 }}</span>
                                            </div>
                                            <div class="stats-weeks-on-chart">
                                                <span class="label">Vị trí<br>TB</span>
                                                <span class="value">1</span>
                                            </div>
                                        </div>
                                        <ul class="fa-ul row-awards">
                                            {% if key ==0 %}
                                                <li><i class="fa fa-li fa-angle-double-up"></i> Vị trí cao nhất
                                                    trong BXH
                                                </li>
                                            {% endif %}
                                            {% if item['increase'] >0 %}
                                                <li><i class="fa fa-li fa-dot-circle-o"></i> Tăng trong tuần</li>
                                            {% else %}
                                                <li><i class="fa fa-li fa-dot-circle-o"></i> Giảm trong tuần</li>
                                            {% endif %}
                                        </ul>
                                    </div>
                                </article>
                                {% endfor %}
                            </section>
                        </div>
                        <!-- /content -->
                    </div>
                    <!-- /tabs -->


                </div>


                {% include "layouts/siderbar_right.volt" %}

            </div>
        </div>
    </div>


</div>

    <!--===================footer=====================-->

    {% include "layouts/footer.volt" %}
{% include "layouts/form_add_playlist.volt" %}