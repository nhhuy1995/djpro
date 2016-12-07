{% if listmedia %}
    <div data-special-type="app">
        <ul class="listtop">
            {% for key,item in listmedia %}
                <li>
                    <span>{{ key+1 }}. </span>
                    <a href="{{ item['link'] }}">
                        {{ item['name'] }}
                    </a>
                </li>
            {% endfor %}
        </ul>
    </div>
    {% include '/layouts/paging.volt' %}
{% else %}
    <p>Chưa cập nhật!</p>
{% endif %}