{% include "/layouts/header.volt" %}
<div id="content">
    <div class="bg-cmmusic">
        <div class="container">
            {% include "/layouts/breadcrumb.volt" %}
        </div>
        <div class="container">
            <div class="row">
                <div class="col-ldh-9 col-sm-8">
                    {% for item in listcategory %}
                        <div class="td_headingw"><h2><a href="{{ item['link'] }}">{{ item['name'] }}</a><i
                                        class="fa fa-angle-right"></i></h2></div>
                        {% if item['listartist'] %}
                            <div class="row">
                                {% for artist in item['listartist'] %}
                                    <div class="col-md-3 col-sm-4 col-xs-6">
                                        <div class="block-music">
                                            <div class="cover-outer-align">
                                                <a href="{{ artist['link'] }}">
                                                    <img class="img-responsive" title="{{ artist['username'] }}" src="{{ artist['priavatar'] }}"
                                                         alt="{{ artist['username'] }}"/>
                                                </a>
                           <span class="icon-plus">
                               <a href="{{ artist['link'] }}" title=""><i class="fa fa-plus"></i></a>
                           </span>
                                            </div>

                                            <div class="details2">
                                                <h3><a href="{{ artist['link'] }}" class="title tooltip-top"
                                                       title="{{ artist['username'] }}">{{ artist['username'] }}
                                                        <span class="paragraph-end"></span></a></h3>
                                            </div>
                                        </div>
                                    </div>
                                {% endfor %}
                            </div>
                        {% else %}
                            <p>Chưa cập nhật!</p>
                        {% endif %}
                    {% endfor %}
                </div>
                {% include "/layouts/siderbar_right.volt" %}
            </div>
        </div>
    </div>

</div>
{% include "/layouts/footer.volt" %}