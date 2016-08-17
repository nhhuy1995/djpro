{% extends 'layouts/sitemap.volt' %}

{% block content %}
    {% for category in listCategorys %}
        <url>
            <loc>{{ domainUri }}/{{ category['link'] }}</loc>
            <changefreq>monthly</changefreq>
            <priority>0.9</priority>
        </url>
        {% if category['child'] %}
            {% for child in category['child'] %}
                <url>
                    <loc>{{ domainUri }}{{ child['link'] }}</loc>
                    <changefreq>monthly</changefreq>
                    <priority>0.9</priority>
                </url>
            {% endfor %}
        {% endif %}
    {% endfor %}
{% endblock %}