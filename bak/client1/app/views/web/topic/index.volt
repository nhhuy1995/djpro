{% include 'layouts/header.volt' %}
<div id="content">

    <div class="banner-gs">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/trang-chu.html"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/chu-de.html">Chủ đề</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="divpre">
                <a href="{{ header.link }}" title="{{ header.name }}" alt="{{ header.name }}">
                    <img height="350" alt="chủ đề" src="{{ header.banner | default("/web/images/relax.jpg") }}">
                </a>

                <div class="box-info-artist">
                    <div class="info-artist fluid">

                        <div class="caption-cd">
                            <a href="{{ header.link }}" title="{{ header.name }}" alt="{{ header.name }}">
                                <div class="info-summary-title"><h1>{{ header.name }}</h1></div>
                            </a>
                            <p>{{ header.description }}
                                {% if header.artist %}
                                -
                                {% for item in header.artist %}
                                <a href="{{ item['link'] }}" title="{{ item['username'] }}" target="_blank"
                                   alt="{{ item['username'] }}">{{ item['username'] }}</a> {% if !loop.last %}ft {% endif %}
                                {% endfor %}
                                {% endif %}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="row">

                <div class="col-md-12 col-sm-12">
                    <div class="td_heading">
                        <h2>
                            <a href="/chu-de-noi-bat.html">
                                <span>CHỦ ĐỀ NỔI BẬT<i class="fa fa-angle-right"></i></span>
                            </a>
                        </h2>
                    </div>

                    <div class="topic_chude">
                        <ul class="row">
                            {% for item in listtopic %}
                            <li class="col-md-4 col-sm-4 col-xs-12">
                                <div>
                                    {% for itemchild in item['listtopic'] %}
                                        {% if loop.first %}
                                            <a title="" target="_top" href="{{ itemchild['link'] }}"
                                               class="box_absolute">
                                                <span class="icon_play"></span>
                                                <img alt="{{ itemchild['name'] }}" title="{{ itemchild['name'] }}"
                                                     src="{{ itemchild['small_banner'] }}">
                                            </a>

                                            <h2><a class="name_topic" href="{{ itemchild['link'] }}"
                                                   title="{{ itemchild['name'] }}">{{ itemchild['name'] }}</a></h2>
                                        {% endif %}
                                    {% endfor %}
                                    <ul>
                                        {% for itemchild in item['listtopic'] %}
                                        {% if !loop.first %}
                                        <li>
                                            <h3><a class="name_song" title="{{ itemchild['name'] }}"
                                                   alt="{{ itemchild['name'] }}"
                                                   href="{{ itemchild['link'] }}">{{ itemchild['name'] }}</a>
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
                    <div class="td_heading">
                        <h2>
                            <a href="/chu-de-moi.html">
                                <span>CHỦ ĐỀ MỚI NHẤT<i class="fa fa-angle-right"></i></span>
                            </a>
                        </h2>
                    </div>
                </div>
                <div class="row">
                    {% for item in listTopic_New %}
                        <div class="col-md-3 col-sm-4 col-xs-6">
                            <div class="block-music">
                                <div class="cover-outer-align">
                                    <a href="{{ item['link'] }}">
                                        <img class="img-responsive" src="{{ item['priavatar'] }}"
                                             alt="{{ item['name'] }}" title="{{ item['name'] }}"/>
                                    </a>
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
                <div class="td_heading">

                    <h2>
                        <a href="/chu-de-chon-loc.html">
                            <span>CHỦ ĐỀ CHỌN LỌC<i class="fa fa-angle-right"></i></span>
                        </a>
                    </h2>
                </div>
            </div>
            <div class="row">
                {% for item in listTopicSelectvie %}
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="block-music">
                            <div class="cover-outer-align">
                                <a href="{{ item['link'] }}">
                                    <img class="img-responsive" title="{{ item['name'] }}" src="{{ item['priavatar'] }}"
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
                                {% include "/layouts/listartist.volt" %}
                            </div>
                        </div>
                    </div>
                {% endfor %}
            </div>
        </div>
    </div>
</div>
    </div>


    </div>
<!--===================footer=====================-->
    {% include 'layouts/footer.volt' %}