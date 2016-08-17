{% include '/layouts/header.volt' %}


<div id="content">
    <div class="bgclr"></div>
    <div class="bg-cmmusic">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/trang-chu.html"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/video.html">Video</a></li>
                <li><a href="/video-moi.html">Video mới</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-ldh-9 col-sm-8">
                    <div class="row">
                        {% for item in listVideo %}
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="block-music">
                                    <div class="cover-outer-align">
                                        <a href="{{ item['link'] }}" title="{{ item['name'] }}">
                                            <img class="img-responsive" src="{{ item['priavatar'] }}" alt=""/>
                                        </a>
                               <span class="icon-circle-play">
                                   <a class="button" href="{{ item['link'] }}" title=""><i class="fa fa-play"></i></a>
                               </span>
                                        <a href="{{ item['link'] }}" title="{{ item['name'] }}">
                                            <div class="video-item-info">
                                            <span class="video-item-view"><span
                                                        class="fa fa-eye"></span> {{ item['view'] }}</span>
                                            <span class="video-item-like"><span
                                                        class="fa fa-clock-o"></span> 12:18</span>
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
                    {% include '/layouts/paging.volt' %}

                </div>
                {% include '/layouts/siderbar_right.volt' %}
            </div>
        </div>
    </div>

</div>

<!--===================footer=====================-->
{% include '/layouts/footer.volt' %}