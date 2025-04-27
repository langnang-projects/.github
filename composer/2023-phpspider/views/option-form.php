<?

use Langnang\lnArray;
use Langnang\lnModel;
use Langnang\PhpSpiderConfigModel;
use Langnang\lnString;
use phpspider\core\db;

class PhpSpiderConfigAnnotationModel extends lnModel
{
  public $name = "";
  public $label = ""; // 显示名称
  public $hidden = false; // 是否隐藏
  public $input_type = "text"; // 输入框类型
  public $disabled = false; // 是否禁用
  public $options = []; // input=='checkbox' 选项
  public $children = []; // 
  function print_html($value)
  {
    if ($this->hidden) return;
    $result = "";
    $result .= "<div class=\"form-group\">";
    $result .= "<label for=\"{$this->name}\" style=\"margin-right: 20px;\">" . ($this->label ?: $this->key) . "</label>";

    switch ($this->input_type) {
      case "radio":
        // export_type
        foreach ($this->options as $option) {
          $result .= "<label class=\"radio-inline\" style=\"margin-top: -5px;\">";
          $result .= "<input type=\"radio\" name=\"{$this->name}\" value=\"{$option['value']}\" style=\"margin-top: 8px;\"" . ($this->name !== 'export_type' && $value == $option['value'] ? ' checked ' : '') . ($this->disabled ? ' disabled ' : '') . ">";
          $result .= "<span style=\"display: inline-block;margin: 5px 0 0 5px;\">{$option['label']}</span>";
          $result .= "</label>";
        }
        break;
      case "checkbox":
        // 
        foreach ($this->options ?: [] as $option) {
          $result .= "<label class=\"checkbox-inline\" style=\"margin-top: -5px;\">";
          $result .= "<input type=\"checkbox\" class=\"form-control\" name=\"{$this->name}\" value=\"{$option['value']}\"" .  (($value == true || strstr($value, $option["value"]) !== false) ?  ' checked ' : '') . ($this->disabled ? ' disabled ' : '') . ">";
          $result .= "<span style=\"display: inline-block;margin: 5px 0 0 5px;\">{$option['label']}</span>";
          if ($this->name == 'template' && $this->disabled) {
            if ($GLOBALS['config']->parent) {
              $result .= "  <b>当前配置套用于 <strong> {$GLOBALS['config']->parent->id} </strong>，部分功能禁止修改</b>";
            } else {
              $result .= "  <b>当前模板已被套用，部分功能禁止修改</b>";
            }
          }
          $result .= "</label>";
        }
        break;
      case "multiselect":
        // 
        $result .= "<div for=\"{$this->name}\" style=\"display: flex;flex-flow: wrap;\">";
        foreach ($value ?: [] as $item) {
          $result .= "<div class=\"alert alert-info\" role=\"alert\">";
          $result .= "{$item}";
          $result .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\" style=\"margin-left:6px;\">";
          $result .= "<span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\" style=\"font-size: 10px;top:-2px\"></span>";
          $result .= "</button>";
          $result .= "</div>";
        }
        $result .= "<input type=\"text\" class=\"form-control\" name=\"{$this->name}\" placeholder=\"{$this->name}\" value=\"\"" . ($this->disabled ? ' disabled ' : '') . ">";
        $result .= "</div>";
        break;
      case "children":
        // export db_config proxy
        $result .= "<div class=\"row\" style=\"margin-top: 10px;\">";
        $result .= "<div class=\"col-md-11 col-md-offset-1\">";
        foreach ($this->children as $child_key => $child_annotation) {
          $child_annotation->name = $this->name . "_" . $child_annotation->name;
          $result .= $child_annotation->print_html($value[$child_key]);
        }
        $result .= "</div>";
        $result .= "</div>";
        break;
      default:
        $result .= "<input type=\"{$this->input_type}\" class=\"form-control\" name=\"{$this->name}\" placeholder=\"{$this->name}\" value=\"{$value}\"" . ($this->disabled ? ' disabled ' : '') . ">";
        break;
    }
    $result .= "</div>";
    return $result;
  }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $hidden_annotations = [];
  $template_annotations = [];

  switch ($route_path) {
    case "install":
      // if (file_exists(dirname(__DIR__) . "/.env{$env}")) {
      //   Header("Location: /");
      //   exit;
      // }
      $hidden_annotations = ["id", "source", "name", "description", "key", "keywords", "log_file", "parent", "fields", "queue_config", "multiserver", "save_running_state", "tasknum", "serverid", "status", "template", "domains", "scan_urls", "list_url_regexes", "content_url_regexes", "time", "export"];
      $env_config = [];
      if (file_exists(dirname(__DIR__) . "/.env{$_SESSION['env']}")) $env_config = parse_ini_file(dirname(__DIR__) . "/.env{$_SESSION['env']}", true);
      $env_config["fields"] = [];
      foreach ($env_config as $key => $value) {
        if (strpos($key, 'fields.') !== false) {
          $env_config["fields"][substr($key, 7)] = $value;
          unset($env_config[$key]);
        }
      }
      $config = new PhpSpiderConfigModel($env_config);
      break;
    case "insert":
      $hidden_annotations = ["id", "mode", "log_show", "log_type", "log_file", "parent", "fields", "queue_config", "multiserver", "save_running_state", "tasknum", "serverid", "status", "proxy", "db_config", "max_fields", "max_depth", "max_try", "timeout", "interval", "client_ip", "input_encoding", "output_encoding", "time"];
      if (isset($_GET['parent'])) {
        $config = db::get_one("SELECT * FROM `{$GLOBALS['tbname']}` WHERE `id` = '{$_GET['parent']}';");
        if (is_null($config)) Header("Location: /");
        $config["parent"] = $config["id"];
        $config["id"] = null;
        $config["template"] = false;
      }
      $config = new PhpSpiderConfigModel($config ?: []);
      break;
    case "update":
      $hidden_annotations = ["id", "mode", "log_show", "log_type", "log_file", "parent", "fields", "queue_config", "multiserver", "save_running_state", "tasknum", "serverid", "status", "proxy", "db_config", "max_fields", "max_depth", "max_try", "timeout", "interval", "client_ip", "input_encoding", "output_encoding", "time"];
      $template_annotations = [];
      // 地址栏没有ID，返回首页
      if (!isset($_GET['id'])) Header("Location: /");
      $config = db::get_one("SELECT * FROM `{$GLOBALS['tbname']}` WHERE `id` = '{$_GET['id']}';");
      // 未查询到结果，返回首页
      if (is_null($config)) Header("Location: /");

      $config = new PhpSpiderConfigModel($config);
      // 模板
      if ($config->template) {
        $child_count = db::get_one("SELECT COUNT(*) as `count` FROM `$tbname` WHERE `parent` = '{$_GET['id']}';");
        $has_children = ($child_count['count'] != 0);
        $config->has_children = $has_children;
      } else if ($config->parent !== '') {
        $config->parent = db::get_one("SELECT * FROM `{$GLOBALS['tbname']}` WHERE `id` = '{$config->parent}';");
        $config->parent = new PhpSpiderConfigModel($config->parent);
        $template_annotations = array_merge($template_annotations, ["template", "export_type", "export_file", "export_table"]);
      }

      $cmd = "";
      if (!lnString::is_window()) {
        $cmd .= "screen -S PhpSpider.\\\"" . $config->key . "\\\" ";
        $cmd .= "php -f " . dirname(__DIR__)  . "/main.php start env=" . substr($env, 1) . " mode=" . ($env_config['mode'] ?: 'default') . " id=" . $config->id . "</pre>";
        $cmd .= "<pre>";
        $cmd .= "screen -r PhpSpider.\\\"" . $config->key . "\\\" ";
      }
      $cmd .= "php -f " . dirname(__DIR__)  . "/main.php start env=" . substr($env, 1) . " mode=" . ($env_config['mode'] ?: 'default') . " id=" . $config->id;
      break;
    default:
      break;
  }
  $input_disabled = $config->parent || $config->has_children;
  $config_annotation = get_phpspider_config_annotation([
    "hidden" => $hidden_annotations,
    "template" => $template_annotations,
  ]);
}
var_dump($config);
?>
<style>
  .alert {
    display: inline-flex;
    padding: 5px 10px;
    margin-bottom: 5px;
    margin-right: 4px;
  }

  input[type='checkbox'] {
    width: 20px;
    height: 20px
  }

  tbody>tr:not(.collapse):first-child .glyphicon-arrow-up,
  tbody>tr:not(.collapse):nth-last-child(2) .glyphicon-arrow-down {
    opacity: 0.5;
    pointer-events: none;
    cursor: not-allowed
  }
</style>
<? if (!empty($cmd)) : ?>
  <!-- 启动命令 -->
  <div class="row">
    <pre><? echo $cmd ?></pre>
  </div>
<? endif ?>
<form class="row form-horizontal">

  <? if ($route_path !== 'install' || (isset($_SESSION["admin"]) && $_SESSION["admin"] === true)) :
  ?>
    <? if ($route_path == 'install') : ?>
      <button type="button" class="btn btn-default pull-right" onclick="logout()">[<? echo substr($_SESSION["env"], 1) ?>] Log Out</button>
    <? endif ?>
    <?
    /** 遍历配置类，读取注释内容 */
    foreach (get_class_vars("Langnang\PhpSpiderConfigModel") as $key => $default_value) :
      echo $config_annotation[$key]->print_html($config->{$key});
    ?>
    <? endforeach ?>
    <table class="table table-striped">
      <caption class="h4 text-center"><b>定义内容页的抽取规则</b></caption>
      <thead>
        <tr>
          <th class="col-sm-2">name</th>
          <th class="col-sm-3">description</th>
          <th class="col-sm-3">selector</th>
          <th width="60">required</th>
          <th width="60">repeated</th>
          <th width="60">table_show</th>
          <th>
            <div class="btn-group btn-group-xs pull-right" role="group">
              <button type="button" class="btn btn-default glyphicon glyphicon-plus" onclick="insertFieldRow(this)" <? echo $input_disabled ? 'disabled' : '' ?>></button>
            </div>
          </th>
        </tr>
      </thead>
      <tbody for="fields">
        <? foreach ($config->fields ?: [] as $index => $field) : ?>
          <tr>
            <td>
              <input type="text" class="form-control" name="field_name" value="<? echo $field->name ?>" <? echo $input_disabled ? 'disabled' : '' ?>>
            </td>
            <td>
              <input type="text" class="form-control" name="field_description" value="<? echo $field->description ?>" <? echo $input_disabled ? 'disabled' : '' ?>>
            </td>
            <td>
              <input type="text" class="form-control" name="field_selector" value="<? echo $field->selector ?>">
            </td>
            <td class="text-center">
              <input type="checkbox" name="field_required" <? if ($field->required == true) echo 'checked' ?> <? echo $input_disabled ? 'disabled' : '' ?>>
            </td>
            <td class="text-center">
              <input type="checkbox" name="field_repeated" <? if ($field->repeated == true) echo 'checked' ?> <? echo $input_disabled ? 'disabled' : '' ?>>
            </td>
            <td class="text-center">
              <input type="checkbox" name="field_table_show" <? if ($field->table_show == true) echo 'checked' ?> <? echo $input_disabled ? 'disabled' : '' ?>>
            </td>
            <td>
              <div class="btn-group btn-group-xs" role="group">
                <button type="button" class="btn btn-default glyphicon glyphicon-arrow-up" onclick="upFieldRow(this)" <? echo $input_disabled ? 'disabled' : '' ?>></button>
                <button type="button" class="btn btn-default glyphicon glyphicon-arrow-down" onclick="downFieldRow(this)" <? echo $input_disabled ? 'disabled' : '' ?>></button>
                <button type="button" class="btn btn-default glyphicon glyphicon-trash" onclick="deleteFieldRow(this)" <? echo $input_disabled ? 'disabled' : '' ?>></button>
                <button type="button" class="btn btn-default glyphicon glyphicon-list" onclick="toggleCollapse(this)" <? echo $input_disabled ? 'disabled' : '' ?>></button>
              </div>
            </td>
          </tr>
          <tr class="collapse <? echo sizeof($field->children ?: []) > 0 ? 'in' : '' ?>">
            <td colspan="999">
              <table class="table table-striped" style="padding:10px;">
                <thead>
                  <tr>
                    <th class="col-sm-2">name</th>
                    <th class="col-sm-3">description</th>
                    <th class="col-sm-3">selector</th>
                    <th width="60">required</th>
                    <th width="60">repeated</th>
                    <th width="60">table_show</th>
                    <th>
                      <div class="btn-group btn-group-xs pull-right" role="group">
                        <button type="button" class="btn btn-default glyphicon glyphicon-plus" onclick="insertFieldRow(this)" <? if ($field->repeated == true) echo 'checked' ?><? echo $input_disabled ? 'disabled' : '' ?>></button>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <? foreach ($field->children ?: [] as $field) : ?>
                    <tr>
                      <td>
                        <input type="text" class="form-control" name="field_name" value="<? echo $field->name ?>" <? echo $input_disabled ? 'disabled' : '' ?>>
                      </td>
                      <td>
                        <input type="text" class="form-control" name="field_description" value="<? echo $field->description ?>" <? echo $input_disabled ? 'disabled' : '' ?>>
                      </td>
                      <td>
                        <input type="text" class="form-control" name="field_selector" value="<? echo $field->selector ?>">
                      </td>
                      <td class="text-center">
                        <input type="checkbox" name="field_required" <? if ($field->required == true) echo 'checked' ?> <? echo $input_disabled ? 'disabled' : '' ?>>
                      </td>
                      <td class="text-center">
                        <input type="checkbox" name="field_repeated" <? if ($field->repeated == true) echo 'checked' ?> <? echo $input_disabled ? 'disabled' : '' ?>>
                      </td>
                      <td class="text-center">
                        <input type="checkbox" name="field_table_show" <? if ($field->table_show == true) echo 'checked' ?> <? echo $input_disabled ? 'disabled' : '' ?>>
                      </td>
                      <td>
                        <div class="btn-group btn-group-xs" role="group">
                          <button type="button" class="btn btn-default glyphicon glyphicon-arrow-up" onclick="upFieldRow(this)" <? echo $input_disabled ? 'disabled' : '' ?>></button>
                          <button type="button" class="btn btn-default glyphicon glyphicon-arrow-down" onclick="downFieldRow(this)" <? echo $input_disabled ? 'disabled' : '' ?>></button>
                          <button type="button" class="btn btn-default glyphicon glyphicon-trash" onclick="deleteFieldRow(this)" <? echo $input_disabled ? 'disabled' : '' ?>></button>
                          <button type="button" class="btn btn-default glyphicon glyphicon-list" onclick="toggleCollapse(this)" <? echo $input_disabled ? 'disabled' : '' ?>></button>
                        </div>
                      </td>
                    </tr>
                    <tr class="collapse">
                    </tr>
                  <? endforeach ?>
                </tbody>
              </table>
            </td>
          </tr>
        <? endforeach ?>
      </tbody>
    </table>
  <? else : ?>
    <div class="form-group">
      <div class="col-md-6 col-md-offset-3">
        <input type="password" class="form-control input-lg" name="password" placeholder="Password">
      </div>
    </div>
  <? endif ?>
  <div class="form-group text-center">
    <button type="button" class="btn btn-default" onclick="submitForm()">提 交</button>
  </div>
</form>

<script>
  <? echo json_encode(get_phpspider_config_annotation_keys($config_annotation, 'multiselect')) ?>.forEach(function(name) {
    $(`input[name='${name}']`).keydown(function(e) {
      if (e.keyCode == 13 && $(e.target).val().trim() !== '') {
        $(e.target).before(`
            <div class="alert alert-info" role="alert">
              ${$(e.target).val().trim()}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-left:6px;"><span class="glyphicon glyphicon-remove" aria-hidden="true" style="font-size: 10px;top:-2px"></span></button>
            </div>
          `);
        $(e.target).val('');
      }
    });
  })
  /**
   * 监听 export.type 导出类型
   * 控制 export.file/export.db 导出文件/表名 显隐
   */
  $("[name='export_type']").on('change', function(e) {
    switch ($(e.target).val()) {
      case "csv":
        $("[name='export_file']").parent().css('display', 'block');
        $("[name='export_table']").parent().css('display', 'none');
        break;
      case "sql":
        $("[name='export_table']").parent().css('display', 'block');
        $("[name='export_file']").parent().css('display', 'block');
        break;
      case "db":
        $("[name='export_file']").parent().css('display', 'none');
        $("[name='export_table']").parent().css('display', 'block');
        break;
      default:
        break;

    }
  })

  function getFormData() {
    const result = {
      password: $(`form [name='password']`).val(),
      parent: <? echo "\"{$config->parent}\""; ?>,
      ...
      <? echo json_encode(get_phpspider_config_annotation_keys($config_annotation, 'checkbox')) ?>.reduce((total, key) => {
        total[key] = [...$(`form [name='${key}']:checked`)].map(e => $(e).val()).join(',')
        return total;
      }, {}),
      ...
      <? echo json_encode(get_phpspider_config_annotation_keys($config_annotation, 'radio')) ?>.reduce((total, key) => {
        total[key] = $(`form [name='${key}']:checked`).val()
        return total;
      }, {}),
      ...
      <? echo json_encode(get_phpspider_config_annotation_keys($config_annotation, 'text')) ?>.reduce((total, key) => {
        total[key] = $(`form [name='${key}']`).val()
        return total;
      }, {}),
      ...
      <? echo json_encode(get_phpspider_config_annotation_keys($config_annotation, 'number')) ?>.reduce((total, key) => {
        total[key] = parseInt($(`form [name='${key}']`).val())
        return total;
      }, {}),
      ...
      <? echo json_encode(get_phpspider_config_annotation_keys($config_annotation, 'multiselect')) ?>.reduce((total, key) => {
        total[key] = [...$(`div[for='${key}']>.alert`)].map((self) => $(self).text().trim())
        return total;
      }, {}),
      ...
      <? echo json_encode(get_phpspider_config_annotation_keys($config_annotation, 'children')) ?>.reduce((total, key) => {
        total[key] = [...$(`form [name^='${key}']`)].reduce((t, e) => {
          t[$(e).attr('name').substr(key.length + 1)] = $(e).val()
          return t
        }, {})
        return total;
      }, {}),
      fields: [...$("tbody[for='fields']>tr:not(.collapse)")].map((self, index) => ({
        ...getFieldData(self),
        children: [...$(`tbody[for='fields']>tr.collapse`).eq(index).find("tbody tr")].map((self) => ({
          ...getFieldData(self),
        }))
      })),
    }
    return result;
  }

  function insertFieldRow(e) {
    $(e).parent().parent().parent().parent().parent().children('tbody').append(`
      <tr>
        <td>
          <input type="text" class="form-control" name="field_name" value="">
        </td>
        <td>
          <input type="text" class="form-control" name="field_description" value="">
        </td>
        <td>
          <input type="text" class="form-control" name="field_selector" value="">
        </td>
        <td class="text-center">
          <input type="checkbox" name="field_required">
        </td>
        <td class="text-center">
          <input type="checkbox" name="field_repeated">
        </td>
        <td class="text-center">
          <input type="checkbox" name="field_table_show">
        </td>
        <td>
          <div class="btn-group btn-group-xs" role="group">
            <button type="button" class="btn btn-default glyphicon glyphicon-arrow-up" onclick="upFieldRow(this)"></button>
            <button type="button" class="btn btn-default glyphicon glyphicon-arrow-down" onclick="downFieldRow(this)"></button>
            <button type="button" class="btn btn-default glyphicon glyphicon-trash" onclick="deleteFieldRow(this)"></button>
            <button type="button" class="btn btn-default glyphicon glyphicon-list" onclick="toggleCollapse(this)"></button>
          </div>
        </td>
              </tr>
              <tr class="collapse">
        <td colspan="999">
          <table class="table table-striped" style="padding:10px;">
            <thead>
              <tr>
        <th class="col-sm-2">name</th>
        <th class="col-sm-3">description</th>
        <th class="col-sm-3">selector</th>
        <th width="60">required</th>
        <th width="60">repeated</th>
        <th width="60">table_show</th>
        <th>
          <div class="btn-group btn-group-xs pull-right" role="group">
            <button type="button" class="btn btn-default glyphicon glyphicon-plus" onclick="insertFieldRow(this)"></button>
          </div>
        </th>
              </tr>
            </thead>
            <tbody>
          </table>
        </td>
      </tr>
      `)
  }

  function upFieldRow(e) {
    const tr = $(e).parent().parent().parent();
    tr.next().insertBefore(tr.prev().prev())
    tr.insertBefore(tr.prev().prev().prev())
  }

  function downFieldRow(e) {
    const tr = $(e).parent().parent().parent();
    tr.next().insertAfter(tr.next().next().next())
    tr.insertAfter(tr.next().next())
  }

  function deleteFieldRow(e) {
    $(e).parent().parent().parent().next().remove()
    $(e).parent().parent().parent().remove()
  }

  function getFieldData(e) {
    return {
      name: $(e).find("input[name='field_name']").val(),
      description: $(e).find("input[name='field_description']").val(),
      selector: $(e).find("input[name='field_selector']").val(),
      required: $(e).find("input[name='field_required']").prop('checked'),
      repeated: $(e).find("input[name='field_repeated']").prop('checked'),
      table_show: $(e).find("input[name='field_table_show']").prop('checked'),
    }
  }

  function logout() {
    $.ajax({
      url: "/logout",
      method: "post",
      success(res) {
        alert("操作成功!!!");
        window.location.href = "/install"
      }
    })
  }

  function submitForm() {
    const data = getFormData();
    console.log(data);
    $.ajax({
      url: "<? echo $_SERVER['REQUEST_URI'] ?>",
      method: "post",
      data,
      success(res) {
        if (data.password) {
          alert(res);
          window.location.reload();
        } else if (res !== "") {
          alert(res);
        } else {
          if (!confirm("操作成功，是否继续？")) {
            window.location.href = "/"
          }
        }

      }
    })
  }

  function insertTask() {
    $.ajax({
      url: "/insert",
      method: "post",
      data: {
        ...getFormData(),
      },
      success(res) {
        if (!confirm("新增成功，是否继续新增？")) {
          window.location.href = "/"

        }
      }
    })
  }

  function updateTask() {
    // console.log(getFormData())
    $.ajax({
      url: "/update",
      method: "post",
      data: {
        id: '<?php echo $_GET['id']; ?>',
        ...getFormData(),
      },
      success(res) {
        if (!confirm("修改成功，是否继续修改？")) {
          window.location.href = "/"
        }
      }
    })
  }
</script>
<script>
  $(document).ready(function() {

    $("[name='export_type'][value='<? echo $config->export['type'] ?>']").prop('checked', true).trigger('change');
  })
</script>
<?

function get_phpspider_config_annotation($config = [], $is_merge = false)
{
  if (!$is_merge) {
    $_config = [
      "hidden" => array_merge(["id", "time", "fields"], $config["hidden"] ?: []),
      "template" => array_merge([], $config["template"] ?: []),
      // 多选框：是否判断
      "boolean" => [
        "template" => "是否为模板",
        "log_show" => "是否显示日志",
        "multiserver" => "多服务器处理: 需要配合redis来保存采集任务数据，供多服务器共享数据使用",
        "save_running_state" => "保存爬虫运行状态: 需要配合redis来保存采集任务数据，供程序下次执行使用",
      ],
      "checkbox" => [
        "log_type" => [
          "label" => "日志类型",
          "options" => [
            "info" => "info: 普通类型",
            "warn" => "warn: 警告类型",
            "debug" => "debug: 调试类型",
            "error" => "error: 错误类型",
          ]
        ],
      ],
      "radio" => [
        "mode" => [
          "label" => "运行模式",
          "options" => [
            "default" => "只增+条件更新",
            "create" => "创建模式",
            "insert" => "新增模式",
            "update" => "更新模式"
          ]
        ]
      ],
      "text" => [
        "key" => "Key，也可用作数据表名",
        "description" => "任务描述",
        "name" => "任务名称",
        "log_file" => "日志文件路径",
        "input_encoding" => "输入编码",
        "output_encoding" => "输出编码",
        "source" => "数据源",
        "parent" => ""
      ],
      "number" => [
        "tasknum" => "同时工作的爬虫任务数: 需要配合redis保存采集任务数据，供进程间共享使用",
        "serverid" => "服务器ID",
        "interval" => "爬虫爬取每个网页的时间间隔（单位：毫秒）",
        "timeout" => "爬虫爬取每个网页的超时时间（单位：秒）",
        "max_try" => "爬虫爬取每个网页失败后尝试次数",
        "max_depth" => "爬虫爬取网页深度，超过深度的页面不再采集",
        "max_fields" => "爬虫爬取内容网页最大条数",
      ],
      "children" => [
        "queue_config" => [
          "label" => "redis配置",
          "children" => [
            "text" => [
              'host'      => '主机名或 IP 地址',
              'pass'      => '密码',
              'prefix'    => 'prefix',
            ],
            "number" => [
              'port'      => 'port',
              'db' => 'db',
              'timeout'   => 'timeout',
            ]
          ],
        ],
        "export" => [
          "label" => "爬虫爬取数据导出",
          "children" => [
            "radio" => [
              "type" => [
                "label" => "导出类型 csv、sql、db",
                "options" => [
                  "csv" => "csv",
                  "sql" => "sql",
                  "db" => "db",
                ]
              ]
            ],
            "text" => [
              // "type" => "导出类型 csv、sql、db",
              "file" => "导出 csv、sql 文件地址",
              "table" => "导出db、sql数据表名",
            ]
          ]
        ],
        "db_config" => [
          "label" => "数据库配置",
          "children" => [
            "text" => [
              'host'  => '主机名或 IP 地址',
              'user'  => '用户名',
              'pass'  => '密码',
              'name'  => '默认使用的数据库',
            ],
            "number" => [
              'port'  => '服务器的端口号',
            ],
          ],
        ]
      ],
      "multiselect" => [
        "keywords" => "关键字",
        "client_ip" => "爬虫爬取网页所使用的伪IP，用于破解防采集",
        "user_agent" => "爬虫爬取网页所使用的浏览器类型",
        "domains" => "定义爬虫爬取哪些域名下的网页, 非域名下的url会被忽略以提高爬取速度",
        "scan_urls" => "定义爬虫的入口链接, 爬虫从这些链接开始爬取,同时这些链接也是监控爬虫所要监控的链接",
        "list_url_regexes" => "定义列表页url的规则",
        "content_url_regexes" => "定义内容页url的规则",
        "proxy" => "代理服务器: 如果爬取的网站根据IP做了反爬虫, 可以设置此项",
      ],
    ];
  } else {
    $_config = $config;
  }

  $result = [];
  foreach ($_config as $type => $annotations) {
    foreach ($annotations as $key => $value) {
      $model = [];
      switch ($type) {
        case "hidden":
          $key = $value;
          $model["hidden"] = true;
          break;
        case "template":
          $key = $value;
          $model["disabled"] = true;
          break;
        case "disabled":
          $key = $value;
          $model["disabled"] = true;
          break;
        case "boolean":
          $model["label"] = $value;
          $model["input_type"] = "checkbox";
          $model["options"] = [["label" => "true", "value" => "1"]];
          break;
        case "radio":
          $model["label"] = $value['label'];
          $model["input_type"] = "radio";
          $model["options"] = array_map(function ($v, $l) {
            return ["label" => $l, "value" => $v];
          }, array_keys($value['options']), $value['options']);
          break;
        case "checkbox":
          $model["label"] = $value['label'];
          $model["input_type"] = "checkbox";
          $model["options"] = array_map(function ($v, $l) {
            return ["label" => $l, "value" => $v];
          }, array_keys($value['options']), $value['options']);
          break;
        case "text":
          $model["label"] =  $value;
          break;
        case "number":
          $model["label"] =  $value;
          $model["input_type"] = "number";
          break;
        case "children":
          $model["label"] =  $value['label'];
          $model["input_type"] = 'children';
          $children = $value['children'];
          $children["hidden"] = array_merge($children["hidden"] ?: []);
          $children["template"] = array_merge($children["template"] ?: [], array_map(
            // 去除
            function ($item) use ($key) {
              return substr($item, lnString::length($key . "_"));
            },
            // 过滤出包含key的字符串
            array_filter($_config["template"], function ($item) use ($key) {
              return lnString::is_exist($item, $key . "_");
            })
          ));
          $model["children"] = get_phpspider_config_annotation($children, true);
          break;
        case "multiselect":
          $model["label"] =  $value;
          $model["input_type"] = "multiselect";
          break;
        default:
          break;
      }
      $model["name"] = $key;
      if (isset($result[$key])) {
        $result[$key]->__construct($model);
      } else {
        $result[$key] = new PhpSpiderConfigAnnotationModel($model);
      }
    }
  }
  return $result;
}
function get_phpspider_config_annotation_keys($config_annotation, $input_type)
{
  return array_keys(
    array_filter(
      $config_annotation,
      function ($annotation) use ($input_type) {
        return $annotation->input_type == $input_type && $annotation->hidden == false;
      }
    )
  );
}
?>