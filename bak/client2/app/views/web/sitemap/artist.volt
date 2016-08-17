{% extends 'layouts/sitemap.volt' %}

{%  block content %}
    {% for item in listArtist %}
        <url>
            <loc>{{ item['link'] }}</loc>
            <changefreq>always</changefreq>
            <priority>0.9</priority>
        </url>
    {% endfor %}
{% endblock %}