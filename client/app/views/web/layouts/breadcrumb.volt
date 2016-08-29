<ul class="breadcrumbs">
    <li itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb">
        <a href="/" itemprop="url">
            <span itemprop="title"><i class="fa fa-home fa-lg"></i></span>
        </a>
    </li>
    {% if breadCrumbs %}
        {% for item in breadCrumbs.getItems() %}
            <li itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb">
                <a href="{{ item['link'] }}" itemprop="url">
                    <span itemprop="title">{{ item['name'] }}</span>
                </a>
            </li>
        {% endfor %}
    {% else %}
        <li>Đang cập nhật!</li>
    {% endif %}
</ul>