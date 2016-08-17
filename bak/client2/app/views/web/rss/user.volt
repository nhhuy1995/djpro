{% extends 'layouts/rss.volt' %}

{%  block content %}
    {% for item in listUser %}
        <item>

            <title><![CDATA[ {{ item['fullname'] }} ]]></title>

            <description><![CDATA[ <a href="{{ item['link'] }}"><img width="140px" src="{{ item['priavatar'] }}" /><br/></a> {{ item['description'] }}]]></description>

            <link>{{ item['link'] }}</link>

            <pubDate>{{ item['public_date'] }}</pubDate>

        </item>
    {% endfor %}
{% endblock %}