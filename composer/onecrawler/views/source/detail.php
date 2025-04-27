{# 详情/目录页面 #}
{% extends 'source/layout.php' %}

{% block title %}Discover - Novel{% endblock %}

{% block _content %}
<div class="jumbotron">
  <div class="row">
    <div class="col-md-3">
      <div style="height: 0;padding-top: 125%;background: url({{detail.cover}});background-size: cover"></div>
    </div>
    <div class="col-md-9">
      <h1 style="font-size: 48px;">{{detail.name}}</h1>

      <p> {{detail.author}} </p>

      <p>
        {% if category %}
        <button name="insertShelf" class="btn btn-primary" attr-content-name="{{detail.name}}" attr-content-uri="{{category.category[0][0].url}}">订阅</button>
        {% endif %}
        {% for down in array(download.download) %}
        <a class="btn btn-info" href="{{down}}">下载地址</a>
        {% endfor %}
      </p>

    </div>
  </div>
</div>

{% if detail.descr %}
<div class="panel panel-default">
  <div class="panel-body">
    {% for descr in array(detail.descr) %}
    <p> {{descr}} </p>
    {% endfor %}
  </div>
</div>
{% endif %}

{% if category.group %}
{% for group in category.group %}
<div class="panel panel-default">
  <div class="panel-heading">{{group}}</div>
  <div class="panel-body">
    <ul class="list-group">
      {% set index0 = loop.index0 %}
      {% for item in category.category[index0] %}
      {% if item.name %}
      <a href="/{{vars.class}}/content/{{vars.id}}?uri={{item.url}}" class="list-group-item col-md-3" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{item.name}}">
        {{item.name}}
      </a>
      {% endif %}
      {% endfor %}
    </ul>
  </div>
</div>
{% endfor %}
{% else %}
<ul class="list-group">
  {% for item in category.category[0] %}
  {% if item.name %}
  <a href="/{{vars.class}}/content/{{vars.id}}?uri={{item.url}}" class="list-group-item col-md-3" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{item.name}}">
    {{item.name}}
  </a>
  {% endif %}
  {% endfor %}
</ul>
{% endif %}

{% endblock %}

{% block _script %}
<script>
  $(document).ready(function() {
    toggleInsertShelf("{{detail.name}}::{{detail.author}}")
  })
</script>
{% endblock %}