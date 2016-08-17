{% include 'layouts/header.volt' %}
<div id="content">
    <div class="bg-cmmusic">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/chu-de.html">Chủ đề</a></li>
                <li><a href="/chu-de-noi-bat.html">Chủ đề nổi bật</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-ldh-9 col-sm-8">
                    <div class="td_heading">
                        <h2><span>CHỦ ĐỀ NỔI BẬT<i class="fa fa-angle-right"></i></span></h2>
                    </div>

                    <div class="topic_chude">
                        <ul class="row">
                            {% for item in listtopic %}
                            <li class="col-md-4 col-sm-4 col-xs-12">
                                <div>
                                    {% for itemchild in item['listtopic'] %}
                                        {% if loop.first %}
                                            <a title="" target="_top" href="{{ itemchild['link'] }}" class="box_absolute">
                                                <span class="icon_play"></span>
                                                <img alt="{{ itemchild['name'] }}" title="{{ itemchild['name'] }}" src="{{ itemchild['small_banner'] }}">
                                            </a>

                                            <h2><a class="name_topic" href="{{ itemchild['link'] }}"
                                                   title="{{ itemchild['name'] }}">{{ itemchild['name'] }}</a></h2>
                                        {% endif %}
                                    {% endfor %}
                                    <ul>
                                        {% for itemchild in item['listtopic'] %}
                                        {% if !loop.first %}
                                        <li>
                                            <h3><a class="name_song"
                                                   href="{{ itemchild['link'] }}" title="{{ itemchild['name'] }}">{{ itemchild['name'] }}</a>
                                            </h3>
                                        </li>
                                        {% endif %}
                                        {% endfor %}

                                    </ul>
                                </div>
                            </li>
                            {% endfor %}
                        </ul>
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