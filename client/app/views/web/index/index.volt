<header id="header">
    {% include "/layouts/header.volt" %}
    <div class="container">
        <div class="adv_728_ipad">
            {{ ads.HOME_TABLET_TOP['current_content'] }}
        </div>
        <div class="adv-300-phone">
            {{ ads.HOME_MOBILE_TOP['current_content'] }}
        </div>
        <div class="row">
            <div class="col-ldh-9 col-sm-12">
                <div class="mod-newsflash-adv posts">
                    <div class="row">

                        <article class="col-md-4 col-sm-4 item item_num0">

                            <div class="item_content">
                                <span class="dropcap">1</span>

                                <div class="item_introtext">
                                    <div class="postContent">
                                        <div class="postplay">
                                            <a href="/bai-hat-de-cu.html">
                                                <i class="fa fa-headphones fa-5x"></i>
                                            </a>
                                        </div>
                                        <a href="/bai-hat-de-cu.html">
                                            <figcaption>Now Playing</figcaption>
                                        </a>
                                        <a href="/bai-hat-de-cu.html">Top bài hát được đề cử nhiều nhất trong tuần bởi
                                            thành viên</a>
                                    </div>
                                    <a href="/bai-hat-de-cu.html" class="customLink">Xem thêm</a></div>

                            </div>

                        </article>
                        <div class="col-md-8 col-sm-8">
                            <div data-special-type="app" class="player-container">
                                <ul id="playlist" class="song-list">
                                    {% for item in listmedia %}
                                        <li>
                                    <span class="song-title"><a href="{{ item['link'] }}" class="tooltip-top"
                                                                title="{{ item['name'] }}">{{ item['name'] }}</a></span>

                                    <span class="song-listen"><i
                                                class="fa fa-headphones"></i> {{ item['view'] }}</span>
                                        </li>
                                    {% endfor %}
                                </ul>
                            </div>
                            <!--End-playlist-->
                        </div>

                    </div>
                </div>

            </div>

            <div class="col-ldh-3 col-sm-4">

                <div class="div1">
                    <div class="adv-300">
                        {{ ads.HOME_DESKTOP_RIGHT_1['current_content'] }}
                    </div>
                    <div class="adv-300">
                        {{ ads.HOME_DESKTOP_RIGHT_2['current_content'] }}
                    </div>

                    <div class="adv-300">
                        {{ ads.HOME_DESKTOP_RIGHT_3['current_content'] }}
                    </div>

                </div>

            </div>
        </div>
    </div>
</header>


<div id="content">
    <div class="bg-event">
        <div class="container mod-newsflash-adv posts">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="td_headingw"><h2><a href="/bai-hat-chon-loc.html">Ca khúc chọn lọc</a><i
                                    class="fa fa-angle-right"></i></h2>
                    </div>

                    <div data-special-type="app" class="player-container2">
                        <ul id="playlist" class="song-list">
                            {% for item in list_SelectiveAudio %}
                                <li>
                                    <span class="song-title"><a href="{{ item['link'] }}" class="tooltip-top"
                                                                title="{{ item['name'] }}">{{ item['name'] }}</a></span>

                                    <span class="song-listen"><i class="fa fa-headphones"></i> {{ item['view'] }}</span>
                                </li>
                            {% endfor %}

                        </ul>
                    </div>
                    <!--End-playlist-->
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="td_headingw"><h2><a href="/top100.html">Top nghe nhiều</a><i
                                    class="fa fa-angle-right"></i></h2>
                    </div>

                    <div data-special-type="app" class="player-container2">
                        <ul id="playlist" class="song-list">
                            {% for item in listMedia_ByView %}
                                <li>
                                    <span class="song-title"><a href="{{ item['link'] }}" class="tooltip-top"
                                                                title="{{ item['name'] }}">{{ item['name'] }}</a></span>

                                    <span class="song-listen"><i class="fa fa-headphones"></i> {{ item['view'] }}</span>
                                </li>
                            {% endfor %}
                        </ul>
                    </div>
                    <!--End-playlist-->
                </div>
            </div>
        </div>
    </div>

    <div class="bg-album">
        <div class="container mod-newsflash-adv posts">
            <div class="row">
                <article class="col-md-3 col-sm-3 item item_num1">
                    <div class="item_content">
                        <span class="dropcap">2</span>

                        <div class="item_introtext">
                            <div class="postContent">
                                <div class="postInnerContent">
                                    <ul class="gallery">
                                        {% for item in listAlbum %}
                                            <li class=""><a href="{{ item['link'] }}" title="{{ item['name'] }}"><img
                                                            src="{{ item['priavatar'] }}" alt="{{ item['name'] }}"></a>
                                            </li>
                                        {% endfor %}
                                    </ul>
                                </div>
                                DS các album mới nhất
                            </div>
                            <a href="/album.html" class="customLink">Xem thêm</a></div>
                    </div>
                </article>

                <div class="col-md-9 col-sm-9 slide-news">
                    <div class="featuredNavigation">
                        <a href="javascript:void(0)" class="left recommended-item-control" title="Prev" id="prev"><i
                                    class="fa fa-angle-left"></i></a>
                        <a href="javascript:void(0)" class="right recommended-item-control" title="Next" id="next"><i
                                    class="fa fa-angle-right"></i></a>
                    </div>

                    <div id="slide" class="our-listing owl-carousel">
                        {% for item in listPlaylist %}
                            <div class="block-music mr10">
                                <div class="cover-outer-align">
                                    <a href="{{ item['link'] }}" title="{{ item['name'] }}"> <img class="img-responsive"
                                                                                                  src="{{ item['priavatar'] }}"
                                                                                                  alt=""/></a>
                               <span class="icon-circle-play">
                                   <a class="button" href="{{ item['link'] }}" title=""><i class="fa fa-play"></i></a>
                               </span>
                                </div>

                                <div class="details">
                                    <h3><a href="{{ item['link'] }}" class="title tooltip-top"
                                           title="{{ item['name'] }}">{{ item['name'] }} <span
                                                    class="paragraph-end"></span></a></h3>

                                    {% include "/layouts/listartist.volt" %}
                                </div>
                            </div>
                        {% endfor %}
                    </div>
                    <!-- /.our-listing -->

                </div>

            </div>
        </div>
    </div>


    <div class="container">

        <!-- /.row -->

        <div class="id-section">
            <div class="td_heading"><h2><a href="/chu-de-chon-loc.html">Chủ đề chọn lọc</a><i
                            class="fa fa-angle-right"></i></h2></div>
            <div class="row">

                {% for item in list_SelectiveTopic %}
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="block-music">
                            <div class="cover-outer-align">
                                <a href="{{ item['link'] }}" title="{{ item['name'] }}"><img class="img-responsive"
                                                                                             src="{{ item['priavatar'] }}"
                                                                                             alt=""/></a>
                               <span class="icon-circle-play">
                                   <a class="button" href="{{ item['link'] }}" title=""><i class="fa fa-play"></i></a>
                               </span>
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
        </div>


        <div class="id-section">
            <div class="td_heading"><h2><a href="/video-chon-loc.html">Video chọn lọc</a><i
                            class="fa fa-angle-right"></i></h2></div>
            <div class="row">
                {% for item in list_SelectiveVideo %}
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="block-music">
                            <div class="cover-outer-align">
                                <a href="{{ item['link'] }}" title="{{ item['name'] }}"><img class="img-responsive"
                                                                                             src="{{ item['priavatar'] }}"
                                                                                             alt=""/></a>
                               <span class="icon-circle-play">
                                   <a class="button" href="{{ item['link'] }}" title=""><i class="fa fa-play"></i></a>
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
        </div>


    </div>
</div>
<!--===================footer=====================-->
{% include "/layouts/footer.volt" %}
<a href="#" class="cd-top">Top</a>
{% include "/layouts/form_add_playlist.volt" %}

