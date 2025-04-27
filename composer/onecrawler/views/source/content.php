{% extends 'source/layout.php' %}

{% block title %}Content - Novel{% endblock %}

{% block _content %}
<h2 class="text-center">{{content.name}}</h2>

{{ include(['source/components/content',vars.class,'php']|join('.')) }}

{% endblock %}

{% block _script %}
<script>
  $(document).ready(function() {
    if (toggleInsertShelf("{{detail.name}}")) {
      const key = "{{detail.name}}";
      const item = getStorage(key);
      item.content.name = "{{content.name}}";
      item.content.uri = "{{vars.uri}}";
      updateStorage(key, item);
    }
  })
</script>
{{content.content}}
{% endblock %}