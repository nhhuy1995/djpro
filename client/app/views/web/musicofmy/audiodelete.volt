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
                                <li class=""><a href="/nhac-da-xoa.html"
                                                class="icon icon-all"><span>Tất cả</span></a></li>
                                <li class="tab-current"><a href="/nhac-da-xoa.html?t=audio" class="icon icon-baihat"><span>Bài hát đã xóa</span></a>
                                </li>
                                <li class=""><a href="/nhac-da-xoa.html?t=playlist"
                                                class="icon icon-playlist"><span>Playlist đã xóa</span></a></li>
                                <li class=""><a href="/nhac-da-xoa.html?t=video"
                                                           class="icon icon-video"><span>Video đã xóa</span></a></li>
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-linemove-2"  style="display: block">
                                <div class="td_heading"><h2><span class="while">Bài hát<i class="fa fa-angle-right"></i></span>
                                    </h2></div>
                                {% include '/layouts/cothebanmuonnghe.volt' %}
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