{# 资源订阅页面 #}


{% extends 'source/layout.php' %}

{% block title %}Subscribe - {{vars.class|u.camel.title}}{% endblock %}

{% block _content %}

<div id="subscribe">

</div>

{% endblock %}


{% block _script %}
<script>
  $(document).ready(function() {
    const storage = getStorage()
    let html = '';
    for (let key in storage) {
      let item = storage[key];
      html += `
      <div class="col-sm-4 col-md-3">
        <input type="checkbox" attr-index="${key}" style="position: absolute;left: 20px;height: 20px; width: 20px;">
        <span class="badge" style="position: absolute;right: 0px;top: -7px;">0</span>
        <a href="/{{vars.class}}/content/${item.source.id}?uri=${item.content.uri}" title="${item.detail.name}">
          <div class="thumbnail">
            <div style="height: 0;padding-top: 125%;background: url(${item.detail.cover});background-size: cover"></div>
            <div class="caption">
              <h4 style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">${item.detail.name}</h4>
            </div>
          </div>
        </a>
      </div>
    `;
    }
    $("#subscribe").append(html);

    $("#deleteAction").on('click', function(e) {
      const indexs = [...$('input[type=checkbox]:checked')].map((el) => $(el).attr('attr-index'));
      deleteStorage(indexs);
      location.reload();
    })

    $("#refreshSubscribe").on('click', function() {
      Object.value
      $.ajax({
        method: "post",
        url: "/api/{{vars.class}}/category",
        data: {
          list: Object.values(getStorage()).map(v => ({
            source: v.source.id,
            category: v.detail.category
          }))
        },
        success: function(res) {
          if (res.status == 200) {
            console.log(res.data);
            res.data.forEach(function(value, index) {
              const totalCount = value.length;
              $("#subscribe .badge").eq(index).text(totalCount);
            })
          }

        }
      })
    })

  })
</script>
{% endblock %}