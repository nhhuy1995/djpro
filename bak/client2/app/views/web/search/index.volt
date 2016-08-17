{% include  "/layouts/header.volt" %}
<div id="content">
    <div class="artists">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/trang-chu.html"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/tim-kiem.html?q={{ keyword }}">{{ _GET['q'] }}</a></li>
                <li>Có tất cả "{{ countTotal }}" kết quả</li>
            </ul>
        </div>
        <div class="container">
            <div class="row">

                <div class="col-ldh-9 col-sm-8">
                    {#<h3 style="color: white;">Tìm kiếm với từ khóa: {{ _GET['q'] }}</h3>#}

                    <div class="td_heading"><h2><span class="while">Danh sách nhạc theo
                                “<a href="/tim-kiem/nhac.html?q={{ keyword }}"><span id="clkeyword">{{ _GET['q'] }}</span></a>”
                                ({{ countaudio }})
                                <i class="fa fa-angle-right"></i></span>
                        </h2></div>
                    {% if listaudio %}
                        <div data-special-type="app" class="player-container">
                            <ul id="playlist" class="song-list">
                                {% for item in listaudio %}
                                    <li>
                                <span class="song-title">
                                    <a href="{{ item['link'] }}" class="tooltip-top"
                                       title="{{ item['name'] }}">{{ item['name'] }} </a>
                                </span>
                                        <span class="song-listen"><i
                                                    class="fa fa-headphones"></i> {{ item['view'] }}</span>
                                    </li>
                                {% endfor %}
                            </ul>
                        </div>

                    {% else %}
                        <p>Không có kết quả nào cho "{{ _GET['q'] }}" </p>
                    {% endif %}
                    <!--  Artist  --->
                    <div class="td_heading"><h2><span class="while">Danh sách nghệ sỹ theo
                                “<a href="/tim-kiem/nghe-sy.html?q={{ keyword }}"><span id="clkeyword">{{ _GET['q'] }}</span></a>”
                               ({{ countartist }})
                                <i class="fa fa-angle-right"></i></span></h2></div>
                    {% if listartist %}
                        <div class="row">
                            {% for item in listartist %}
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="block-music">
                                        <div class="cover-outer-align">
                                            <a href="{{ item['link'] }}">
                                                <img class="img-responsive" title="{{ item['username'] }}"
                                                     src="{{ item['priavatar'] }}"
                                                     alt="{{ item['username'] }}"/>
                                            </a>
                           <span class="icon-plus">
                               <a href="{{ item['link'] }}" title=""><i class="fa fa-plus"></i></a>
                           </span>
                                        </div>

                                        <div class="details2">
                                            <h3><a href="{{ item['link'] }}" class="title tooltip-top"
                                                   title="{{ item['username'] }}">{{ item['username'] }}
                                                    <span class="paragraph-end"></span></a></h3>
                                        </div>
                                    </div>
                                </div>
                            {% endfor %}
                        </div>
                    {% else %}
                        <p>Không có kết quả nào cho "{{ _GET['q'] }}" </p>
                    {% endif %}
                    <div class="td_heading"><h2><span class="while">Danh sách album theo
                                “<a href="/tim-kiem/album.html?q={{ keyword }}"><span id="clkeyword">{{ _GET['q'] }}</span></a>”
                                ({{ countalbum }})
                                <i class="fa fa-angle-right"></i></span>
                        </h2>
                    </div>
                    {% if listalbum %}
                        <div class="row">
                            {% for item in listalbum %}
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="block-music">
                                        <div class="cover-outer-align">
                                            <a href="{{ item['link'] }}" title="{{ item['name'] }}">
                                                <img class="cover-image" src="{{ item['priavatar'] }}"
                                                     alt="{{ item['name'] }}"/>
                                            </a>
                               <span class="icon-circle-play">
                                   <a class="button" href="{{ item['link'] }}" title=""><i class="fa fa-play"></i></a>
                               </span>
                                        </div>

                                        <div class="details">
                                            <h3><a class="title" href="{{ item['link'] }}"
                                                   title="{{ item['name'] }}">{{ item['name'] }}
                                                    <span class="paragraph-end"></span></a></h3>

                                            {% include "/layouts/listartist.volt" %}
                                        </div>
                                    </div>
                                </div>
                            {% endfor %}
                        </div>
                    {% else %}
                        <p>Không có kết quả nào cho "{{ _GET['q'] }}" </p>
                    {% endif %}
                    <div class="td_heading">
                        <h2><span class="while">Danh sách playlist theo
                                “<a href="/tim-kiem/playlist.html?q={{ keyword }}"><span id="clkeyword">{{ _GET['q'] }}</span></a>”
                                ({{ countplaylist }})
                                <i class="fa fa-angle-right"></i></span>
                        </h2>
                    </div>
                    {% if listplaylist %}
                        <div class="row">
                            {% for item in listplaylist %}
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="block-music">
                                        <div class="cover-outer-align">
                                            <a href="{{ item['link'] }}" title="{{ item['name'] }}">
                                                <img class="cover-image" src="{{ item['priavatar'] }}"
                                                     alt="{{ item['name'] }}"/>
                                            </a>
                               <span class="icon-circle-play">
                                   <a class="button" href="{{ item['link'] }}" title=""><i class="fa fa-play"></i></a>
                               </span>
                                        </div>

                                        <div class="details">
                                            <h3><a class="title" href="{{ item['link'] }}"
                                                   title="{{ item['name'] }}">{{ item['name'] }}
                                                    <span class="paragraph-end"></span></a></h3>

                                            {% include "/layouts/listartist.volt" %}
                                        </div>
                                    </div>
                                </div>
                            {% endfor %}
                        </div>
                    {% else %}
                        <p>Không có kết quả nào cho "{{ _GET['q'] }}" </p>
                    {% endif %}
                    <div class="td_heading"><h2><span class="while">Danh sách chủ đề theo
                                “<a href="/tim-kiem/chu-de.html?q={{ keyword }}"><span id="clkeyword">{{ _GET['q'] }}</span></a>”
                                ({{ counttopic }})
                                <i class="fa fa-angle-right"></i></span>
                        </h2>
                    </div>
                    {% if listtopic %}
                        <div class="row">
                            {% for item in listtopic %}
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="block-music">
                                        <div class="cover-outer-align">
                                            <a href="{{ item['link'] }}" title="{{ item['name'] }}">
                                                <img class="cover-image" src="{{ item['priavatar'] }}"
                                                     alt="{{ item['name'] }}"/>
                                            </a>
                               <span class="icon-circle-play">
                                   <a class="button" href="{{ item['link'] }}" title=""><i class="fa fa-play"></i></a>
                               </span>
                                        </div>

                                        <div class="details">
                                            <h3><a class="title" href="{{ item['link'] }}"
                                                   title="{{ item['name'] }}">{{ item['name'] }}
                                                    <span class="paragraph-end"></span></a></h3>

                                            {% include "/layouts/listartist.volt" %}
                                        </div>
                                    </div>
                                </div>
                            {% endfor %}
                        </div>
                    {% else %}
                        <p>Không có kết quả nào cho "{{ _GET['q'] }}" </p>
                    {% endif %}
                    <div class="td_heading"><h2>
                            <span class="while">Danh sách video theo
                                “<a href="/tim-kiem/video.html?q={{ keyword }}"><span id="clkeyword">{{ _GET['q'] }}</span></a>”
                                ({{ countvideo }})
                                <i class="fa fa-angle-right"></i></span>
                        </h2>
                    </div>
                    {% if listvideo %}
                        <div class="row">
                            {% for item in listvideo %}
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="block-music">
                                        <div class="cover-outer-align">
                                            <a href="{{ item['link'] }}" title="{{ item['name'] }}">
                                                <img class="cover-image" src="{{ item['priavatar'] }}"
                                                     alt="{{ item['name'] }}"/>
                                            </a>
                                   <span class="icon-circle-play">
                                       <a class="button" href="{{ item['link'] }}" title="{{ item['name'] }}"><i
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
                                                   title="{{ item['name'] }}"> {{ item['name'] }}
                                                    <span class="paragraph-end"></span></a></h3>

                                            {% include "/layouts/listartist.volt" %}
                                        </div>
                                    </div>
                                </div>
                            {% endfor %}
                        </div>
                    {% else %}
                        <p>Không có kết quả nào cho "{{ _GET['q'] }}" </p>
                    {% endif %}
                </div>
                {% include  "/layouts/siderbar_right.volt" %}

            </div>
        </div>
    </div>


</div>

<!--===================footer=====================-->

{% include  "/layouts/footer.volt" %}
{% include  "/layouts/form_add_playlist.volt" %}

