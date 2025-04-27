<div class="row">
  <div class="col-md-offset-2 col-md-8">
    <nav aria-label="...">
      <ul class="pager">
        <li class="previous"><a href="/{{vars.class}}/content/{{vars.id}}?uri={{content.prev}}">上一章</a></li>
        <li><a href="/{{vars.class}}/detail/{{vars.id}}?uri={{detail.category}}">目录</a></li>
        <li name="insertShelf" attr-content-name="{{content.name}}" attr-content-uri="{{vars.uri}}" style="margin-left: 20%;"><a href="#">订阅</a></li>
        <li class="next"><a href="/{{vars.class}}/content/{{vars.id}}?uri={{content.next}}">下一章</a></li>
      </ul>
    </nav>
  </div>
</div>
<hr />
<div>
  {% for paragraph in content.content %}
  <p style="font-size: 16px;">{{paragraph}}</p>
  {% endfor %}
</div>

<hr>
<div class="row">
  <div class="col-md-offset-2 col-md-8">
    <nav aria-label="...">
      <ul class="pager">
        <li class="previous"><a href="/{{vars.class}}/content/{{vars.id}}?uri={{content.prev}}">上一章</a></li>
        <li><a href="/{{vars.class}}/detail/{{vars.id}}?uri={{detail.category}}">目录</a></li>
        <li name="insertShelf" attr-content-name="{{content.name}}" attr-content-uri="{{vars.uri}}" style="margin-left: 20%;"><a href="#">订阅</a></li>
        <li class="next"><a href="/{{vars.class}}/content/{{vars.id}}?uri={{content.next}}">下一章</a></li>
      </ul>
    </nav>
  </div>
</div>