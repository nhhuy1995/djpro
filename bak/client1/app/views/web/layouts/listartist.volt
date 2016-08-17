<div class="hide-ns">
    {% if item['listartist'] %}
    {% for itemchild in item['listartist'] %}
    <a class="subtitle" href="{{ itemchild['link'] }}"
       title="{{ itemchild['username'] }}">{{ itemchild['username'] }}</a>{% if !loop.last %}<span class="bull" style="font-size:12px;">Ft </span>{% endif %}
    {% endfor %}
    <span class="paragraph-end"></span>
    {% endif %}
</div>