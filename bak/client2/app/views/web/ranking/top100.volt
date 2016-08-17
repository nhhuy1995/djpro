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
                <li><a href="/top100.html">TOP 100</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="row">

                <div class="col-ldh-9 col-sm-8">

                    <div class="td_heading"><h2><span class="while">TOP 100<i
                                        class="fa fa-angle-right"></i></span></h2></div>

                    <div class="tabs tabs-style-iconbox">
                        <nav>
                            <ul>
                                <li class="tab-current"><a href="/top100.html" class="icon icon-baihat"><span>Bài hát</span></a>
                                </li>
                                <li ><a href="/top100.html?t=video" class="icon icon-video"><span>Video</span></a>
                                </li>
                                <li><a href="/top100.html?t=topic" class="icon icon-chude"><span>Chủ đề</span></a>
                                </li>
                                <li><a href="/top100.html?t=album" class="icon icon-album"><span>Album</span></a>
                                </li>
                                <li><a href="/top100.html?t=playlist" class="icon icon-playlist"><span>Playlist</span></a>
                                </li>
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-linemove-1"  class="content-current">
                                {% for key,item in listAudio %}
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
                                                    Tháng trước: {% if item['increase'] is not defined %} -- {% else %} {{ item['last_month'] }} {% endif %}
                                                </span>
                                            </div>
                                            <div class="row-image"><a href="{{ item['link'] }}"
                                                                      title="{{ item['name'] }}"><img
                                                            src="{{ item['priavatar'] }}" alt="{{ item['name'] }}"/></a></div>
                                            <div class="row-title">
                                                <a href="{{ item['link'] }}" class="title_audio" title="{{ item['name'] }}">
                                                    <h2>{{ item['name'] }}</h2>
                                                </a>

                                                <h3>
                                                     {% for itemchild in item['artist'] %}
                                                        <a href="{{ itemchild['link'] }}" title="{{ itemchild['username'] }}">{{ itemchild['username'] }}</a>
                                                    {% if !loop.last %}<span style="font-weight: normal;">ft</span>{% endif %}
                                                    {% endfor %}
                                                </h3>
                                                <span><i class="fa fa-headphones"></i> {{ item['view'] }}</span>
                                            </div>
                                        </div>
                                        <div class="row-secondary">
                                            <div class="stats">
                                                <div class="stats-last-week">
                                                    <span class="label">Tháng trước</span>
                                                    <span class="value">
                                                      {% if item['increase'] is not defined %} -- {% else %} {{ item['last_month'] }} {% endif %}
                                                    </span>
                                                </div>
                                                <div class="stats-top-spot">
                                                    <span class="label">Vị trí cao nhất</span>
                                                    <span class="value">{{ item['highest'] }}</span>
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
