{% include 'layouts/header.volt' %}
<div id="content">
    <div class="bg-cmmusic">
        <div class="container">
            {% include 'layouts/breadcrumb.volt' %}
        </div>
        <div class="container">
            <div class="row">
                <div class="col-ldh-9 col-sm-8">
                    <div class="td_headingw"><h2><a href="/album-chon-loc.html">Playlist CHỌN LỌC</a><i
                                    class="fa fa-angle-right"></i></h2></div>
                    <div class="row">
                        {% for item in listPlaylist_selective %}
                            <div class="col-md-3 col-sm-4 col-xs-6">
                                <div class="block-music">
                                    <div class="cover-outer-align">
                                        <a href="{{ item['link'] }}">
                                            <img class="img-responsive" src="{{ item['priavatar'] }}"
                                                 alt="{{ item['name'] }}"/>
                                        </a>
                           <span class="icon-circle-play">
                               <a class="button" href="{{ item['link'] }}" title=""><i class="fa fa-play"></i></a>
                           </span>
                                    </div>

                                    <div class="details">
                                        <h3><a href="{{ item['link'] }}" class="title tooltip-top"
                                               title="{{ item['name'] }}">{{ item['name'] }}
                                                <span class="paragraph-end"></span></a></h3>

                                        <div>
                                            {% include "/layouts/listartist.volt" %}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {% endfor %}
                    </div>


                    {% include 'layouts/paging.volt' %}
                </div>

                {% include 'layouts/siderbar_right.volt' %}
            </div>
        </div>
    </div>

</div>

<!--===================footer=====================-->
{% include 'layouts/footer.volt' %}