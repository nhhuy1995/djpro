{% include 'layouts/header.volt' %}
<div id="content">
    <div class="bg-cmmusic">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/tim-kiem/playlist.html?q={{ keyword }}">{{ _GET['q'] }}</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-ldh-9 col-sm-8">
                    <div class="td_headingw"><h2>Danh sách playlist theo
                            “<a href="/tim-kiem/playlist.html?q={{ keyword }}"><span id="clkeyword">{{ _GET['q'] }}</span></a>”
                            ({{ count }})
                            <i class="fa fa-angle-right"></i>
                        </h2>
                    </div>
                    {% if listdata %}
                    <div class="row">
                        {% for item in listdata %}
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
                    {% include 'layouts/paging.volt' %}
                    {% else %}
                        <p>Không có kết quả nào cho "{{ _GET['q'] }}" </p>
                    {% endif %}
                </div>

                {% include 'layouts/siderbar_right.volt' %}
            </div>
        </div>
    </div>

</div>

<!--===================footer=====================-->
{% include 'layouts/footer.volt' %}