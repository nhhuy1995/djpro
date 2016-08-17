<rss version="2.0">
    <channel>
        <title>{{ headerName }} - {{ sitename | upper }}</title>
        <description>{{ headerName }} - {{ sitename | upper }}</description>
        <link>{{ domainUri }}</link>
        <copyright>{{ sitename | upper }}</copyright>
        <generator>{{ sitename | upper }}:{{ sitename | upper }}</generator>
        <pubDate>{{ date('d-m-Y') }}</pubDate>
        <lastBuildDate>{{ date('d-m-Y') }}</lastBuildDate>

        {% block content %}
        {% endblock %}
    </channel>
</rss>