{# 资源配置页面 #}
{% extends 'source/layout.php' %}

{% set placeholder_xpath = 'xpath::过滤器|过滤器; 多个换行输入' %}
{% set placeholder_regexp = '正则表达式; 多个换行输入' %}
{% set placeholder_addition = '参数名（可相同）::路径xPath::过滤器|过滤器;多个换行输入' %}
{% block title %}Source - Novel{% endblock %}


{% block _content %}

<style>
  textarea.form-control {
    resize: vertical;
  }
</style>
<form class="form-horizontal" name="source">
  <ul class="nav nav-tabs nav-justified" role="tablist" style="margin-bottom: 10px;">
    <li role="presentation" class="active"><a href="#basic" aria-controls="basic" role="tab" data-toggle="tab">基础</a></li>
    <li role="presentation"><a href="#discover" aria-controls="discover" role="tab" data-toggle="tab">发现</a></li>
    <li role="presentation"><a href="#search" aria-controls="search" role="tab" data-toggle="tab">搜索</a></li>
    <li role="presentation"><a href="#detail" aria-controls="detail" role="tab" data-toggle="tab">详情</a></li>
    <li role="presentation"><a href="#category" aria-controls="category" role="tab" data-toggle="tab">目录</a></li>
    <li role="presentation"><a href="#content" aria-controls="content" role="tab" data-toggle="tab">内容</a></li>
    <li role="presentation"><a href="#download" aria-controls="download" role="tab" data-toggle="tab">下载</a></li>
    <li role="presentation"><a href="#automation" aria-controls="automation" role="tab" data-toggle="tab">自动化</a></li>
  </ul>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="basic">
      <div class="form-group">
        <label class="col-sm-2 control-label">资源名称</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="name" placeholder="name" value="{{item.name}}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">资源 URL</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="url" placeholder="url" value="{{item.url}}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">资源分组</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="group" placeholder="group1;group2;..." value="{{item.group}}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label"> 附加 </label>
        <div class="col-sm-10">
          <textarea class="form-control" name="addition" rows="2" placeholder="{{placeholder_addition}}">{{addition}}</textarea>
        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="discover">
      <div class="form-group">
        <label class="col-sm-2 control-label">发现 URL</label>
        <div class="col-sm-10">
          <textarea class="form-control" name="discover.url" rows="1" placeholder="分类名::URL;多个换行输入;参数page:页码;">{{item.discover.url}}</textarea>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-2 control-label">总数</label>
        <div class="col-sm-10">
          <textarea class="form-control" name="discover.total" rows="1" placeholder="{{placeholder_xpath}}">{{item.discover.total}}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">页数</label>
        <div class="col-sm-10">
          <textarea class="form-control" name="discover.pages" rows="1" placeholder="{{placeholder_xpath}}">{{item.discover.pages}}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">页码</label>
        <div class="col-sm-10">
          <textarea class="form-control" name="discover.page" rows="1" placeholder="{{placeholder_xpath}}">{{item.discover.page}}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label"> 附加 </label>
        <div class="col-sm-10">
          <textarea class="form-control" name="discover.addition" rows="2" placeholder="{{placeholder_addition}}">{{discover.addition}}</textarea>
        </div>
      </div>
      {{ include(['source','components','detail-form-group.php']|join('/'), {key:'discover'}) }}
      <div class="form-group">
        <label class="col-sm-2 control-label">测试::发现</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="test.discover" value="0" placeholder="分类次序: 0,1,2,3,..."></textarea>
        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="search">
      <div class="form-group">
        <label class="col-sm-2 control-label">搜索 URL</label>
        <div class="col-sm-10">
          <textarea class="form-control" name="search.url" rows="1" placeholder="/search?key=\{\{key}}&page=\{\{page}};key:搜索内容;page:页码;">{{item.search.url}}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">总数</label>
        <div class="col-sm-10">
          <textarea class="form-control" name="search.total" rows="1" placeholder="{{placeholder_xpath}}">{{item.search.total}}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">页数</label>
        <div class="col-sm-10">
          <textarea class="form-control" name="search.pages" rows="1" placeholder="{{placeholder_xpath}}">{{item.search.pages}}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">页码</label>
        <div class="col-sm-10">
          <textarea class="form-control" name="search.page" rows="1" placeholder="{{placeholder_xpath}}">{{item.search.page}}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label"> 附加 </label>
        <div class="col-sm-10">
          <textarea class="form-control" name="search.addition" rows="2" placeholder="{{placeholder_addition}}">{{search.addition}}</textarea>
        </div>
      </div>
      {{ include(['source','components','detail-form-group.php']|join('/'), {key:'search'}) }}
      <div class="form-group">
        <label class="col-sm-2 control-label">测试::搜索</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="test.search" value="{{nav.name}}"></textarea>
        </div>
      </div>
    </div>

    <div role="tabpanel" class="tab-pane" id="detail">
      <div class="form-group">
        <label class="col-sm-2 control-label">详情 URL 正则</label>
        <div class="col-sm-10">
          <textarea class="form-control" name="detail.urlRegex" rows="1" placeholder="{{placeholder_regexp}}">{{item.detail.urlRegex}}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label"> 附加 </label>
        <div class="col-sm-10">
          <textarea class="form-control" name="detail.addition" rows="2" placeholder="{{placeholder_addition}}">{{detail.addition}}</textarea>
        </div>
      </div>
      {{ include(['source','components','detail-form-group.php']|join('/'), {key:'detail'}) }}
      <div class="form-group">
        <label class="col-sm-2 control-label">测试::详情</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="test.detail" placeholder="url"></textarea>
        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="download">
      <div class="form-group">
        <label class="col-sm-2 control-label">详情 URL 正则</label>
        <div class="col-sm-10">
          <textarea class="form-control" name="download.urlRegex" rows="1" placeholder="{{placeholder_regexp}}">{{item.download.urlRegex}}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label"> 附加 </label>
        <div class="col-sm-10">
          <textarea class="form-control" name="download.addition" rows="2" placeholder="{{placeholder_addition}}">{{download.addition}}</textarea>
        </div>
      </div>
      {{ include(['source','components','detail-form-group.php']|join('/'), {key:'download'}) }}
      <div class="form-group">
        <label class="col-sm-2 control-label">测试::下载</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="test.download" placeholder="url"></textarea>
        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="category">
      <div class="form-group">
        <label class="col-sm-2 control-label">详情 URL
          <i class="glyphicon glyphicon-info-sign" style="line-height: 18px;vertical-align: top;" data-toggle="tooltip" data-placement="top" title="关联详情页，提取详情页面信息"></i>
        </label>
        <div class="col-sm-10">
          <textarea class="form-control" name="category.parentUrl" rows="1" placeholder="{{placeholder_xpath}}">{{item.category.parentUrl}}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">目录 URL 正则</label>
        <div class="col-sm-10">
          <textarea class="form-control" name="category.urlRegex" rows="1" placeholder="{{placeholder_regexp}}">{{item.category.urlRegex}}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">目录分组</label>
        <div class="col-sm-10">
          <textarea class="form-control" name="category.group" rows="1" placeholder="{{placeholder_xpath}}">{{item.category.group}}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label"> 附加 </label>
        <div class="col-sm-10">
          <textarea class="form-control" name="category.addition" rows="2" placeholder="{{placeholder_addition}}">{{category.addition}}</textarea>
        </div>
      </div>
      {{ include(['source','components','content-form-group.php']|join('/'), {key:'category'}) }}
      <div class="form-group">
        <label class="col-sm-2 control-label">测试::目录</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="test.category" placeholder="url"></textarea>
        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="content">
      <div class="form-group">
        <label class="col-sm-2 control-label">详情 URL
          <i class="glyphicon glyphicon-info-sign" style="line-height: 18px;vertical-align: top;" data-toggle="tooltip" data-placement="top" title="关联详情页，提取详情页面信息"></i>
        </label>
        <div class="col-sm-10">
          <textarea class="form-control" name="content.parentUrl" rows="1" placeholder="{{placeholder_xpath}}">{{item.content.parentUrl}}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">内容 URL 正则</label>
        <div class="col-sm-10">
          <textarea class="form-control" name="content.urlRegex" rows="1" placeholder="{{placeholder_regexp}}">{{item.content.urlRegex}}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label"> 附加 </label>
        <div class="col-sm-10">
          <textarea class="form-control" name="content.addition" rows="2" placeholder="{{placeholder_addition}}">{{content.addition}}</textarea>
        </div>
      </div>
      {{ include(['source','components','content-form-group.php']|join('/'), {key:'content'}) }}
      <div class="form-group">
        <label class="col-sm-2 control-label">测试::内容</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="test.content" placeholder="url"></textarea>
        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="automation"></div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-2">
      <a href="/{{vars.class}}/source" class="btn btn-default btn-block">返回</a>
    </div>
    {% if vars.id != 'insert' %}
    <div class="col-sm-2">
      <button id="tempSource" type="button" class="btn btn-success btn-block">暂存</button>
    </div>
    {% endif %}
    <div class="col-sm-{% if vars.id != 'insert' %}2{% else %}4{% endif %}">
      <button id="submitSource" type="button" class="btn btn-primary btn-block">提交</button>
    </div>
    <div class="col-sm-2">
      <button id="testSource" type="button" class="btn btn-info btn-block">测试</button>
    </div>
  </div>
</form>

{% endblock %}

{% block _script %}
<script>
  $(document).ready(function() {
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
    $("#submitSource,#tempSource").on('click', function(e) {
      const id = $(this).attr('id')
      // 利用对象的指针传递
      $.ajax({
        method: "post",
        url: "/api/{{vars.class}}/source/{% if vars.id == 'insert' %}insert{% else %}update?id={{vars.id}}{% endif %}",
        data: getSource(),
        success: function(res) {
          if (res.status == 200) {
            if (id === 'submitSource') {
              window.location.href = "/{{vars.class}}/source";
            }
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