{% extends 'layouts/sitemap.volt' %}

{%  block content %}
    {% for playlist in listPlaylist %}
        <url>
            <loc>{{ playlist['link'] }}</loc>
            <changefreq>always</changefreq>
            <priority>0.9</priority>
        </url>
    {% endfor %}
{% endblock %}