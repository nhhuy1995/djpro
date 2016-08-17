{% include  "/layouts/header.volt" %}
<div id="content">
    <div class="artists">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/trang-chu.html"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/tim-kiem/nhac.html?q={{ keyword }}">{{ _GET['q'] }}</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="row">

                <div class="col-ldh-9 col-sm-8">
                    {#<h3 style="color: white;">Tìm kiếm với từ khóa: {{ _GET['q'] }}</h3>#}

                    <div class="td_heading"><h2><span class="while">Danh sách nhạc theo
                                “<a href="/tim-kiem/nhac.html?q={{ keyword }}"><span id="clkeyword">{{ _GET['q'] }}</span></a>”
                            ({{ countaudio }})
                                <i class="fa fa-angle-right"></i></span>
                        </h2></div>
                    {% if listaudio %}
                        <div data-special-type="app" class="player-container">
                            <ul id="playlist" class="song-list">
                                {% for item in listaudio %}
                                    <li>
                                <span class="song-title">
                                    <a href="{{ item['link'] }}" class="tooltip-top"
                                       title="{{ item['name'] }}">{{ item['name'] }} </a>
                                </span>
                                <span class="song-duration">
                                    <b class="tooltip-demo"><a href="{{ item['link'] }}" class="tooltip-top"
                                                               title="Play"><i
                                                    class="fa fa-play"></i></a></b>
                                    {% if session['_id'] %}
                                        <b class="tooltip-demo"><a href="javascript:void(0)"
                                                                   onclick="showFormAddPlaylist()"
                                                                   class="cd-signin tooltip-top"
                                                                   title="Thêm vào play list"><i class="fa fa-plus"></i></a></b>
                                        {% else %}
                                        <b class="add-like tooltip-demo">
                                            <a href="javascript:void(0)" class="cd-signin tooltip-top"
                                               title="Thêm vào play list">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </b>
                                    {% endif %}

                                    <b class="tooltip-demo"><a href="/download?id={{ item['_id'] }}" class="tooltip-top"
                                                               title="Tải về"><i
                                                    class="fa fa-download"></i></a></b>
                                </span>
                                        <span class="song-listen"><i
                                                    class="fa fa-headphones"></i> {{ item['view'] }}</span>
                                    </li>
                                {% endfor %}
                            </ul>

                        </div>
                        {% include 'layouts/paging.volt' %}
                    {% else %}
                        <p>Không có kết quả nào cho "{{ _GET['q'] }}" </p>
                    {% endif %}
                </div>
                {% include  "/layouts/siderbar_right.volt" %}

            </div>
        </div>
    </div>


</div>

<!--===================footer=====================-->

{% include  "/layouts/footer.volt" %}
{% include  "/layouts/form_add_playlist.volt" %}

