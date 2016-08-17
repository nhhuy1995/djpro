{% include "/layouts/header.volt" %}
<div id="content">
    <div class="bg-cmmusic">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/tim-kiem/nghe-sy.html?q={{ keyword }}">{{ _GET['q'] }}</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-ldh-9 col-sm-8">
                    <div class="td_headingw"><h2>Danh sách nghệ sỹ theo
                            “<a href="/tim-kiem/nghe-sy.html?q={{ keyword }}"><span id="clkeyword">{{ _GET['q'] }}</span></a>”
                            ({{ countartist }})
                            <i class="fa fa-angle-right"></i></h2>
                    </div>
                    {% if listartist %}
                    <div class="row">
                        {% for item in listartist %}
                            <div class="col-md-3 col-sm-4 col-xs-6">
                                <div class="block-music">
                                    <div class="cover-outer-align">
                                       <a href="{{ item['link'] }}" title="{{ item['username'] }}">
                                           <img class="img-responsive" src="{{ item['priavatar'] }}"
                                                alt="{{ item['username'] }}"/>
                                       </a>
                           <span class="icon-plus">
                               <a href="{{ item['link'] }}" title=""><i class="fa fa-plus"></i></a>
                           </span>
                                    </div>

                                    <div class="details2">
                                        <h3><a href="{{ item['link'] }}" class="title tooltip-top"
                                               title="Đàm Vĩnh Hưng">{{ item['username'] }}
                                                <span class="paragraph-end"></span></a></h3>
                                    </div>
                                </div>
                            </div>
                        {% endfor %}
                    </div>
                    {% include "/layouts/paging.volt" %}
                    {% else %}
                        <p>Không có kết quả nào cho "{{ _GET['q'] }}" </p>
                    {% endif %}
                </div>
                {% include "/layouts/siderbar_right.volt" %}
            </div>
        </div>
    </div>

</div>
{% include "/layouts/footer.volt" %}