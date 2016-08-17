{% include "/layouts/header.volt" %}


<div id="content">
    <div class="bg-news">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/trang-chu.html"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/tin-tuc.html">Tin tức</a></li>
                <li><a href="{{ catinfo.link }}">{{ catinfo.name }}</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-ldh-9 col-sm-8">
                    {% if listNews %}
                    <div class="row">
                        {% for item in listNews %}
                            <div class="thumbnail-news col-md-6 col-sm-12">
                                <figure>
                                    <a href="{{ item['link'] }}" title="{{ item['name'] }}">
                                        <img src="{{ item['priavatar'] }}" title="{{ item['name'] }}" alt="{{ item['name'] }}">
                                    </a>
                                </figure>
                                <div class="caption">
                                    <h3><a href="{{ item['link'] }}" title="{{ item['name'] }}"> {{ item['name'] }}</a></h3>

                                    <p class="date">
                                        <i class="fa fa-eye"></i> {{ item['view'] }} &nbsp;
                                        <i class="fa fa-clock-o"></i> {{ date('d/m/y | H:i:s',item['datecreate']) }}
                                    </p>
                                </div>
                            </div>
                        {% endfor %}
                    </div>
                    {% include '/layouts/paging.volt' %}
                    {% else %}
                        <p style="color: white;">Chưa cập nhật!</p>
                    {% endif %}
                </div>
                {% include "/layouts/siderbar_right.volt" %}

            </div>
        </div>
    </div>

</div>

<!--===================footer=====================-->
{% include "/layouts/footer.volt" %}