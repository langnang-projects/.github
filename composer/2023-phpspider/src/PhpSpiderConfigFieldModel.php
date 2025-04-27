<?

namespace Langnang;

class PhpSpiderConfigFieldModel extends lnModel
{
  public $name = "";
  public $description = "";
  public $selector = "";
  public $required = false;
  public $repeated = false;
  public $children = [];
  /**
   * 是否在数据表格页面显示
   */
  public $table_show = true;
  /**
   * 环境标签
   */
  public $env_flag = false;
  // function __construct($field = [])
  // {
  //   $field = (array)$field;
  //   foreach (['name', 'description',  'selector', 'required', 'repeated', 'children', 'table_show', 'env_flag'] as $name) {
  //     $this->{$name} = isset($field[$name]) ? $field[$name] : $this->{$name};
  //   }
  //   $this->required = ($field["required"] === "true" || $field["required"] === true) ? true : false;
  //   $this->repeated = ($field["repeated"] === "true" || $field["repeated"] === true) ? true : false;
  //   $this->table_show = ($field["table_show"] === "true" || $field["table_show"] === true) ? true : false;
  //   if (isset($field['children']) && is_array($field['children']) && sizeof($field['children']) > 0) {
  //     $this->children =  array_map(function ($field) {
  //       return new PhpSpiderConfigFieldModel($field);
  //     }, $field['children']);
  //   }
  // }
}
