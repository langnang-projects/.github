{% if pages and page %}
<style>
  .pager>.active>a,
  .pager>.active>a:focus,
  .pager>.active>a:hover,
  .pager>.active>span,
  .pager>.active>span:focus,
  .pager>.active>span:hover {
    z-index: 3;
    color: #fff;
    cursor: default;
    background-color: #337ab7;
    border-color: #337ab7;
  }
</style>
<div class="row">
  <div class="col-md-12">
    <nav aria-label="...">
      <ul class="pager">
        <li class="previous"><a href="?">首页</a></li>
        {% if page - 1 == 2  %}
        <li><a href="?">上一页</a></li>
        {% else %}
        <li class="{% if page - 1 == 0  %}disabled{% endif %}"><a href="?page={{page - 1}}">上一页</a></li>
        {% endif %}
        {% for i in 4..1 %}
        {% if page - i >= 1  %}
        {% if page - i == 1  %}
        <li><a href="?">{{page - i}}</a></li>
        {% else %}
        <li><a href="?page={{page - i}}">{{page - i}}</a></li>
        {% endif %}
        {% endif %}
        {% endfor %}
        <li class="active"><a href="?page={{page}}">{{page}}</a></li>
        {% for i in 1..4 %}
        {% if page + i <= pages  %}
        <li><a href="?page={{page + i}}">{{page + i}}</a></li>
        {% endif %}
        {% endfor %}
        <li class="{% if page + 1 > pages  %}disabled{% endif %}"><a href="?page={{page + 1}}">下一页</a></li>
        <li class="next"><a href="?page={{pages}}">尾页</a></li>
      </ul>
    </nav>
  </div>
</div>
{% endif %}