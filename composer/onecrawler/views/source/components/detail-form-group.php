<div class="panel panel-default">
  <div class="panel-heading">详情</div>
  <div class="panel-body" style="padding: 15px 0;">
    <div class="form-group">
      <label class="col-sm-2 control-label">容器</label>
      <div class="col-sm-10">
        <textarea class="form-control" name="{{key}}.item.container" rows="1" placeholder="{{placeholder_xpath}}">{{item[key].item.container}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label"> URL</label>
      <div class="col-sm-10">
        <textarea class="form-control" name="{{key}}.item.url" rows="1" placeholder="{{placeholder_xpath}}">{{item[key].item.url}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">名称</label>
      <div class="col-sm-10">
        <textarea class="form-control" name="{{key}}.item.name" rows="1" placeholder="{{placeholder_xpath}}">{{item[key].item.name}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">封面</label>
      <div class="col-sm-10">
        <textarea class="form-control" name="{{key}}.item.cover" rows="1" placeholder="{{placeholder_xpath}}">{{item[key].item.cover}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">介绍</label>
      <div class="col-sm-10">
        <textarea class="form-control" name="{{key}}.item.descr" rows="1" placeholder="{{placeholder_xpath}}">{{item[key].item.descr}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">作者</label>
      <div class="col-sm-10">
        <textarea class="form-control" name="{{key}}.item.author" rows="1" placeholder="{{placeholder_xpath}}">{{item[key].item.author}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">类型</label>
      <div class="col-sm-10">
        <textarea class="form-control" name="{{key}}.item.kind" rows="1" placeholder="{{placeholder_xpath}}">{{item[key].item.kind}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">状态</label>
      <div class="col-sm-10">
        <textarea class="form-control" name="{{key}}.item.status" rows="1" placeholder="{{placeholder_xpath}}">{{item[key].item.status}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">目录 URL
        <i class="glyphicon glyphicon-info-sign" style="line-height: 18px;vertical-align: top;" data-toggle="tooltip" data-placement="top" title="关联目录页，提取目录页面信息"></i>
      </label>
      <div class="col-sm-10">
        <textarea class="form-control" name="{{key}}.item.category" rows="1" placeholder="{{placeholder_xpath}}">{{item[key].item.category}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">下载 URL
        <i class="glyphicon glyphicon-info-sign" style="line-height: 18px;vertical-align: top;" data-toggle="tooltip" data-placement="top" title="关联下载页，提取下载页面信息"></i>
      </label>
      <div class="col-sm-10">
        <textarea class="form-control" name="{{key}}.item.download" rows="1" placeholder="{{placeholder_xpath}}">{{item[key].item.download}}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label"> 附加 </label>
      <div class="col-sm-10">
        <textarea class="form-control" name="{{key}}.item.addition" rows="2" placeholder="{{placeholder_addition}}">{{item[key].item.addition}}</textarea>
      </div>
    </div>
  </div>
</div>