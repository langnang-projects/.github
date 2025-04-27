{# 发现分类列表页面 #}
{% extends 'source/layout.php' %}

{% block title %}Discover - Novel{% endblock %}

{% block _content %}
<div class="row">
  {% for item in discover.item %}
  <a href="/{{vars.class}}/detail/{{vars.id}}?uri={{item.url}}" title="{{item.name}}">
    <div class="col-sm-4 col-md-3">
      <div class="thumbnail">
        {% if source.discover.item.cover %}
        <div style="height: 0;padding-top: 125%;background: url({{item.cover}});background-size: cover"></div>
        {% endif %}
        <div class="caption">
          <h4 style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">{{item.name}}</h4>
          <p>{{item.kind}}</p>
        </div>
      </div>
    </div>
  </a>
  {% endfor %}

</div>

{{include('source/components/pager.php',{total:discover.total,pages:discover.pages,page:discover.page})}}

{% endblock %}