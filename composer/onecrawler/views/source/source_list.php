{# 资源列表页面 #}
{% extends 'source/layout.php' %}

{% block title %}Source - Novel{% endblock %}

{% block _content %}
<ul class="list-group">
  {% for item in list %}
  <a class="list-group-item" href="/{{vars.class}}/source/{{item.id}}">
    <div class="checkbox" style="margin: 0;">
      <label>
        <input name="checkbox" type="checkbox" attr-id="{{item.id}}">
        <span href="/{{vars.class}}/source/{{item.id}}">
          {{item.name}}
          {% for tag in item.group|split(';') %}
          <span class="badge">{{tag}}</span>
          {% endfor %}
        </span>
      </label>
    </div>
  </a>
  <a class="pull-right" href="{{item.url}}" target="_blank" style="margin-top: -30px;margin-right: 10px;">
    <i class="glyphicon glyphicon-share pull-right"></i>
  </a>
  {% endfor %}
</ul>
{% endblock %}

{% block _script %}
<script>
  $(document).ready(function() {
    $("#deleteAction").on('click', function(e) {
      const ids = [...$('input[type=checkbox]:checked')].map((el) => $(el).attr('attr-id'));
      $.ajax({
        method: "post",
        url: "/api/{{vars.class}}/source/delete",
        data: {
          ids,
        },
        success: function(res) {
          if (res.status == 200) {
            window.location.href = "/{{vars.class}}/source";
          }
        }
      })
    })

    function getSource() {
      const data = [...$("form[name=source] input,form[name=source] textarea")].reduce(function(total, el) {
        $(el).attr("name").split('.').reduce(function(tot, key, index, array) {
          if (array.length - 1 == index) {
            tot[key] = $(el).val()
            return tot;
          }
          if (!tot[key]) tot[key] = {};
          return tot[key];
        }, total);
        return total;
      }, {})
      return data;
    }
    $("#submitSource").on('click', function(e) {
      // 利用对象的指针传递
      $.ajax({
        method: "post",
        url: "/api/{{vars.class}}/source/{{vars.action}}?$index={{vars.index}}",
        data: getSource(),
        success: function(res) {
          if (res.status == 200) {
            window.location.href = "/{{vars.class}}/source";
          }
        }
      })
    })
    $("#testSource").on('click', function(e) {
      $.ajax({
        method: "post",
        url: "/api/{{vars.class}}/source/test",
        data: getSource(),
        success: function(res) {
          if (res.status == 200) {
            console.log(res.data);
          }
        }
      })
    })
  })
</script>
{% endblock %}