{% extends 'layouts/sitemap.volt' %}

{%  block content %}
    {%  if listAlbums is not empty %}
        {% for album in listAlbums %}
            <url>
                <loc>{{ album['link'] }}</loc>
                <changefreq>always</changefreq>
                <priority>0.9</priority>
            </url>
        {% endfor %}
    {% endif %}
{% endblock %}