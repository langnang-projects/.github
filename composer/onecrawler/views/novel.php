{% extends "layout.php" %}

{% block title %}Novel{% endblock %}

{% block content %}
<div class="container">

  <ol class="breadcrumb">
    <li>小说</li>
    <li class="active" style="cursor: pointer;">
      <div class="dropdown" style="display: inline-block;">
        <span id="dropdownMenu1" data-toggle="dropdown">
          书架
          <span class="caret"></span>
        </span>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
          <li><a href="./novel">书架</a></li>
          <li><a href="./novel?type=discover">发现</a></li>
        </ul>
      </div>
    </li>
    <form class="form-inline" style="float: right;margin-top: -5px;">
      <span class="input-group" style="display: none;">
        <input type="text" class="form-control" placeholder="Search" name="type" value="search">
      </span>
      <div class="input-group input-group-sm">
        <input type="text" class="form-control input-sm" placeholder="Search" name="key">
        <span class="input-group-btn">
          <button class="btn btn-default" type="submit">
            <i class="glyphicon glyphicon-search"></i>
          </button>
        </span>
      </div>
    </form>
  </ol>

  {% for item in discoverUrls %}
  <li><a href="?type=discover&index={{loop.index - 1}}">{{ item.name }}</a></li>

  {% endfor %}

  {% for item in list %}
  {% if vars.type=='discover' or vars.type=='search' %}
  <a class="list-group-item col-md-12" href="?type=category&uri={{item.url}}">
    <div class="col-md-6">
      <h4> {{ implode('', array(item.name)) }}</h4>
    </div>
  </a>
  {% elseif vars.type=='category' %}
  <a class="list-group-item col-md-3" href="?type=chapter&uri={{item.url}}" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{item.name}}">
    {{item.name}}
  </a>
  {% elseif vars.type=='chapter' %}
  <h3 class="text-center">{{item.name}}</h3>
  <hr>
  <div class="source-item_content">
    {% for paragraph in array(item.content) %}
    <p>{{paragraph}}</p>
    {% endfor %}

  </div>
  {% endif %}

  {% endfor %}
</div>

{% endblock %}