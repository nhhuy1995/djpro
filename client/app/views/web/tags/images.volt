{% include "/layouts/header.volt" %}


<div id="content">
    <div class="bg-news">
        <div class="container">
            {% include "/layouts/breadcrumb.volt" %}
        </div>
        <div class="container">
            <div class="row">
                <div class="col-ldh-9 col-sm-8">

                    <div class="row">
                        {% for item in listdata %}
                            <div class="thumbnail-news col-md-6 col-sm-12">
                                <figure>
                                    <a href="{{ item['link'] }}">
                                        <img src="{{ item['priavatar'] }}" alt="{{ item['name'] }}">
                                    </a>
                                </figure>
                                <div class="caption">
                                    <h3><a href="{{ item['link'] }}"> {{ item['name'] }}</a></h3>

                                    <p class="date"><i
                                                class="fa fa-clock-o"></i> {{ date('d/m/y | H:i:s',item['datecreate']) }}
                                    </p>
                                </div>
                            </div>
                        {% endfor %}
                    </div>

                    {% include '/layouts/paging.volt' %}

                </div>

                {% include "/layouts/siderbar_right.volt" %}

            </div>
        </div>
    </div>

</div>

<!--===================footer=====================-->
{% include "/layouts/footer.volt" %}