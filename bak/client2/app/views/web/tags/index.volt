{% include  "/layouts/header.volt" %}
<div id="content">
    <div class="artists">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/trang-chu.html"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{ object.link }}">{{ object.name }}</a></li>
                {#<li>Có tất cả "{{ countTotal }}" kết quả</li>#}
            </ul>
        </div>
        <div class="container">
            <div class="row">

                <div class="col-ldh-9 col-sm-8">
                    {% if listaudio %}
                    <div class="td_heading"><h2><span class="while">Danh sách nhạc theo tags
                                “<a href="{{ link_view_tags_audio }}"><span id="clkeyword">{{ object.name }}</span></a>”
                                ({{ countaudio }})
                                <i class="fa fa-angle-right"></i></span>
                        </h2></div>
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
                    {% endif %}
                    {% if listalbum %}
                    <div class="td_heading"><h2><span class="while">Danh sách album theo tags
                                “<a href="{{ link_view_tags_album }}"><span id="clkeyword">{{ object.name }}</span></a>”
                                ({{ countalbum }})
                                <i class="fa fa-angle-right"></i></span>
                        </h2>
                    </div>
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
                    {% endif %}
                    {% if listplaylist %}
                    <div class="td_heading">
                        <h2><span class="while">Danh sách playlist theo tags
                                “<a href="{{ link_view_tags_playlist }}"><span id="clkeyword">{{ object.name }}</span></a>”
                                ({{ countplaylist }})
                                <i class="fa fa-angle-right"></i></span>
                        </h2>
                    </div>
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
                    {% endif %}
                    {% if listtopic %}
                    <div class="td_heading"><h2><span class="while">Danh sách chủ đề tags
                                “<a href="{{ link_view_tags_topic }}"><span id="clkeyword">{{ object.name }}</span></a>”
                                ({{ counttopic }})
                                <i class="fa fa-angle-right"></i></span>
                        </h2>
                    </div>
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
                    {% endif %}
                    {% if listvideo %}
                    <div class="td_heading"><h2>
                            <span class="while">Danh sách video theo tags
                                “<a href="{{ link_view_tags_video }}"><span id="clkeyword">{{ object.name }}</span></a>”
                                ({{ countvideo }})
                                <i class="fa fa-angle-right"></i></span>
                        </h2>
                    </div>
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
                    {% endif %}
                    <!-- list news -->
                    {% if listnews %}
                    <div class="td_heading"><h2>
                            <span class="while">Danh sách tin tức theo tags
                                “<a href="{{ link_view_tags_news }}"><span id="clkeyword">{{ object.name }}</span></a>”
                                ({{ countnews }})
                                <i class="fa fa-angle-right"></i></span>
                        </h2>
                    </div>
                        <div class="row">
                            {% for item in listnews %}
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
                    {% endif %}
                    <!-- list images -->
                    {% if listimages %}
                        <div class="td_heading"><h2>
                            <span class="while">Danh sách ảnh theo tags
                                “<a href="{{ link_view_tags_images }}"><span id="clkeyword">{{ object.name }}</span></a>”
                                ({{ countimages }})
                                <i class="fa fa-angle-right"></i></span>
                            </h2>
                        </div>
                        <div class="row">
                            {% for item in listimages %}
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

