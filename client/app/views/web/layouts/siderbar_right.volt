<div class="col-ldh-3 col-sm-4">
    <div class="div2">
        <div class="adv-300">
            {{ ads.HOME_DESKTOP_RIGHT_1['current_content'] }}
        </div>
        <div class="adv-300">
            {{ ads.HOME_DESKTOP_RIGHT_2['current_content'] }}
        </div>

        <div class="adv-300">
            {{ ads.HOME_DESKTOP_RIGHT_3['current_content'] }}
        </div>

    </div>
    <div class="sidebar">
        <h2 class="heading">Có thể bạn muốn nghe</h2>

        <div class="main-boder">
            <div data-special-type="app" class="player-container2">
                <div data-special-type="app" class="player-container2">
                    <ul class="listtop">

                        {% for key,item in listMusic %}
                            {% set cl = 'special-4' %}
                            {% if key == 0 %} {% set cl = 'special-1' %} {% endif %}
                            {% if key == 1 %} {% set cl = 'special-2' %} {% endif %}
                            {% if key == 2 %} {% set cl = 'special-3' %} {% endif %}
                            <li><a href="{{ item['link'] }}"><span
                                            class="number {{ cl }}">{{ key+1 }}</span>{{ item['name'] }}
                                </a></li>
                        {% endfor %}
                    </ul>
                    <!--menu-->
                </div>
            </div>
        </div>
    </div>
    <!--End-sidebar-->
    <div class="adv-300 div2">
        {{ ads.MUSIC_PLAY_DESKTOP_BELOW_SUGGEST['current_content'] }}
    </div>
</div>