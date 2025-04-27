{# 资源布局页面 #}

{% extends "layout.php" %}

{% block content %}
<div class="container">
  {% block _header %}
  <ol class="breadcrumb">
    <li>{{nav.name}}</li>
    <li style="cursor: pointer;">
      <div class="dropdown" style="display: inline-block;">
        <span id="dropdownMenu1" data-toggle="dropdown">
          {{breadcrumb[0].name}}
          <span class="caret"></span>
        </span>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
          <li><a href="/{{vars.class}}">订阅</a></li>
          <li><a href="/{{vars.class}}/discover">发现</a></li>
          <li><a href="/{{vars.class}}/search">搜索</a></li>
          <li><a href="/{{vars.class}}/source">资源</a></li>
        </ul>
      </div>
    </li>
    {% for item in breadcrumb|slice(1) %}
    {% if item != null %}
    <li>
      {% if item.options %}
      <div class="dropdown" style="display: inline-block;">
        <span id="dropdownMenu1" data-toggle="dropdown">
          {{item.name}}
          <span class="caret"></span>
        </span>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
          {% for opt in item.options %}
          <li><a href="/{{vars.class}}/{{opt.href}}">{{opt.name}}</a></li>
          {% endfor %}
        </ul>
      </div>
      {% else %}
      {% if item.href %}
      <a href="{{item.href}}">{{item.name}}</a>
      {% else %}
      {{item.name}}
      {% endif %}
      {% endif %}
    </li>
    {% endif %}
    {% endfor %}

    <form class="form-inline" action="/{{vars.class}}/search" style="float: right;margin-top: -5px;">
      <div class="btn-group btn-group-sm" role="group" aria-label="...">
        <a href="#" type="button" class="btn btn-default"> <i class="glyphicon glyphicon-th"></i> </a>
        <a href="#" type="button" class="btn btn-default"> <i class="glyphicon glyphicon-th-list"></i> </a>
      </div>
      <div class="btn-group btn-group-sm" role="group" aria-label="...">
        <button id="refreshSubscribe" type="button" class="btn btn-default">刷新</button>
        <button id="checkAll" type="button" class="btn btn-default">全选</button>
        <button id="checkNone" type="button" class="btn btn-default" style="display: none;">全不选</button>
        <a href="/{{vars.class}}/source/insert" class="btn btn-default">新增</a>
        <button id="deleteAction" type="button" class="btn btn-default">删除</button>
        <a type="button" class="btn btn-default" href="/{{vars.class}}/export">导出</a>
      </div>

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
  {% endblock %}
  {% block _content %}
  {% endblock %}

</div>

{% endblock %}
{% block script %}
<script>
  function insertStorage(item) {
    const storage = getStorage();
    storage[item.detail.name + "::" + item.detail.author] = item;
    setStorage(storage);
  }

  function deleteStorage($indexs = []) {
    console.log($indexs);
    const storage = getStorage();
    $indexs.forEach((key) => {
      delete storage[key];
    })
    setStorage(storage);
  }

  function updateStorage($index, item) {
    const storage = getStorage();
    storage[$index] = item;
    setStorage(storage);
  }

  function getStorage(name) {
    storage = JSON.parse(localStorage.getItem('OneCrawler{{vars.class|u.camel.title}}')) || {};
    if (name) return storage[name];
    return storage;
  }

  function setStorage(storage) {
    localStorage.setItem('OneCrawler{{vars.class|u.camel.title}}', JSON.stringify(storage));
  }

  function toggleInsertShelf(name) {
    const item = getStorage(name)
    if (item) {
      [...$("[name=insertShelf]")].forEach(el => $(el).addClass('disabled'))
      return true;
    }
    return false;
  }
  $(document).ready(function() {

    $("#checkAll").on('click', function() {
      $('input[type=checkbox]').prop('checked', true)
      $("#checkAll").css('display', 'none');
      $("#checkNone").css('display', 'block');
    })
    $("#checkNone").on('click', function() {
      $('input[type=checkbox]').prop('checked', false)
      $("#checkAll").css('display', 'block');
      $("#checkNone").css('display', 'none');
    })

    $("[name=insertShelf]").on('click', function() {
      if ($(this).hasClass('disabled')) return;
      const item = {
        source: {
          id: "{{source.id}}",
          name: "{{source.name}}",
          url: "{{source.url}},"
        },
        category: [],
        detail: {
          name: "{{detail.name}}",
          author: "{{detail.author}}",
          cover: "{{detail.cover}}",
          category: "{{detail.category}}",
        },
        content: {
          name: $(this).attr('attr-content-name'),
          uri: $(this).attr('attr-content-uri'),
        },
      };
      insertStorage(item);
      location.reload();
    })



  })
</script>


{% block _script %}
<script>
  $(document).ready(function() {

  })
</script>
{% endblock %}


{% endblock %}