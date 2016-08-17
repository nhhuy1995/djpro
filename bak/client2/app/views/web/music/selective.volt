{% include 'layouts/header.volt' %}
<div id="content">
    <div class="bg-cmmusic">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="/bai-hat.html">Bài hát</a></li>
                <li><a href="/bai-hat-chon-loc.html">Bài hát chọn lọc</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-ldh-9 col-sm-8">

                    <div data-special-type="app" class="player-container">
                        <ul id="playlist" class="song-list">
                            {% for item in listAudio_selective %}
                                <li>
                                    <span class="song-title"><a href="{{ item['link'] }}" class="tooltip-top"
                                                                title="{{ item['name'] }}">{{ item['name'] }}</a></span>

                                    <span class="song-listen"><i class="fa fa-headphones"></i> {{ item['view'] }}</span>
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
{% include 'layouts/form_add_playlist.volt' %}
