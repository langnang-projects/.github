{# 搜索列表页面 #}
{% extends 'source/layout.php' %}

{% block title %}Search - Novel{% endblock %}

{% block _content %}

<div class="col-md-8 col-md-offset-2">
  <form class="form" action="/{{vars.class}}/search">
    <div class="form-group">
      <div class="input-group input-group-lg">
        <input type="text" class="form-control" placeholder="Search" name="key">
        <span class="input-group-btn">
          <button class="btn btn-default" type="submit">
            <i class="glyphicon glyphicon-search"></i>
          </button>
        </span>
      </div>
    </div>
  </form>
</div>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  {% for key in list|keys %}
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading_{{loop.index0}}">
      <h3 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{loop.index0}}" aria-expanded="true" aria-controls="collapse_{{loop.index0}}" style="display: block;">
          {{key|split("::")[0]}}
          <small>{{key|split("::")[1]}}</small>
          <span class="badge pull-right">{{list[key]|length}}</span>
        </a>
      </h3>
    </div>
    <div id="collapse_{{loop.index0}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_{{loop.index0}}">
      <div class="panel-body">
        {% for item in list[key] %}
        <a href="/{{vars.class}}/detail/{{item.source.id}}?uri={{item.url}}" class="badge" style="padding: 6px;">{{item.source.name}}</a>
        {% endfor %}
      </div>
    </div>
  </div>
  {% endfor %}
</div>
{% endblock %}