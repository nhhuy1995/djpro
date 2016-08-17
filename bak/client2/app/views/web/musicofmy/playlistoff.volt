{#<script type="text/javascript" src="/web/js/cbpFWTabs.js"></script>#}
{% include '/layouts/header.volt' %}

<div id="content">


    <div class="artists">
        <div class="container">
            <div class="row">

                <div class="col-ldh-9 col-sm-8">

                    <div class="tabs tabs-style-linemove">
                        <nav>
                            <ul>
                                <li class=""><a href="/nhac-cho-duyet.html"
                                                class="icon icon-all"><span>Tất cả</span></a></li>
                                <li class=""><a href="/nhac-cho-duyet.html?t=audio" class="icon icon-baihat"><span>Bài hát đã đăng</span></a>
                                </li>
                                <li class="tab-current"><a href="/nhac-cho-duyet.html?t=playlist"
                                                class="icon icon-playlist"><span>Playlist đã đăng</span></a></li>
                                <li class=""><a href="/nhac-cho-duyet.html?t=video"
                                                           class="icon icon-video"><span>Video đã đăng</span></a></li>
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-linemove-3"  style="display: block">
                                <div class="td_heading"><h2><span class="while">Playlist<i
                                                    class="fa fa-angle-right"></i></span></h2></div>
                                {% if listplaylist %}
                                    <div class="row">
                                        {% for item in listplaylist %}
                                            <div class="col-md-3 col-sm-4 col-xs-6">
                                                <div class="block-music">
                                                    <div class="cover-outer-align">
                                                        <a href="{{ item['link'] }}">
                                                            <img class="cover-image" title="{{ item['name'] }}" src="{{ item['priavatar'] }}" alt=""/>
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
                                    {% include '/layouts/paging.volt' %}
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
                            <img src="{{ uinfo['priavatar'] }}" alt=""/>
                        </div>

                        <div class="summary">

                            {#<h2 class="title_user">Xin chào: <a href="{{ uinfo['link'] }}" title="{{ uinfo['username'] }}" style="color: #c73030;">{{ uinfo['username'] }}</a> ({{ uinfo['namerole'] }})</h2>#}
                            {% include '/musicofmy/block_right.volt' %}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!--===================footer=====================-->
{% include '/layouts/footer.volt' %}