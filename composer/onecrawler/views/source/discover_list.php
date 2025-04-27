{# 发现列表页面 #}
{% extends 'source/layout.php' %}

{% block title %}Discover - Novel{% endblock %}

{% block _content %}
<div class="row">
  {% for item in sources %}
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="heading_{{loop.index0}}">
        <h4 class="panel-title">
          <a href="/{{vars.class}}/source/{{item.id}}">
            {{item.name}}
          </a>
          {% for tag in item.group|split(';') %}
          <span class="badge">{{tag}}</span>
          {% endfor %}
          <a href="{{item.url}}" target="_blank">
            <i class="glyphicon glyphicon-share pull-right"></i>
          </a>
        </h4>
        </a>
      </div>
      <div class="panel-body">
        {% for urlItem in item.discover.urlGroup %}
        {% if urlItem.name %}
        <a class="badge" href="/{{vars.class}}/discover/{{item.id}}/{{loop.index0}}">
          {{urlItem.name}}
        </a>
        {% endif %}
        {% endfor %}
      </div>
    </div>
  </div>
  {% endfor %}
</div>
{% endblock %}