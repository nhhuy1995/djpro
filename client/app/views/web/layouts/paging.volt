<div class="pagination">
    <ul class="paginationBar">
        <li><a href="{{ painginfo['currentlink'] }}p={{ painginfo['page']-1<=1?1:painginfo['page']-1 }}"
               class="navigation-button"> Trước </a></li>
        {% for index,item in painginfo['rangepage'] %}
            <li class="{{ item==painginfo['page']?"active":"" }}">
                {% if item==painginfo['page'] %}
                    <a class="active">{{ item }}</a>
                {% else %}
                    <a href="{{ painginfo['currentlink'] }}p={{ item }}" class="">{{ item }}</a>
                {% endif %}
            </li>
        {% endfor %}
        <li>
            <a href="{{ painginfo['currentlink'] }}p={{ painginfo['page']+1>=painginfo['totalpage']?painginfo['totalpage']:painginfo['page']+1 }}"
               class="navigation-button">Sau</a></li>
    </ul>
</div>

