{% extends 'layouts/rss.volt' %}

{%  block content %}
    {% for item in listArtist %}
        <item>

            <title><![CDATA[ {{ item['username'] }} ]]></title>

            <description><![CDATA[ <a href="{{ item['link'] }}"><img width="140px" src="{{ item['priavatar'] }}" /><br/></a> {{ item['description'] }}]]></description>

            <link>{{ item['link'] }}</link>

            <pubDate>{{ item['public_date'] }}</pubDate>

        </item>
    {% endfor %}
{% endblock %}