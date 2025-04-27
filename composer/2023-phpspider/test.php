<?

use Langnang\lnArray;
use Langnang\lnString;

require_once __DIR__ . '/vendor/autoload.php';

/**
 *  使用 xpath 读取页面中所有链接地址，并归纳分组相同域名下的链接
 */


// if (!isset($_GET['url'])) die("请在地址栏中输入目标地址");

// TODO 使用 xpath 读取页面中所有链接地址，并归纳分组相同域名下的链接
$url = $_GET["url"];
$max_depth = (int)($_GET["max_depth"] ?: 0);
// $url = "https://rfdjz9.jiuse200.com/";

// 页面内容
$html = file_get_contents($url);
// 缓存至本地，便于查看页面结构
// file_put_contents(__DIR__ . "/.html", $html);

// $html = file_get_contents(__DIR__ . "/.html");
if (substr($url, -1) !== "/") $url .= "/";
// var_dump($html);
//将爬取到的源码转换为HTML解析
$dom = new DOMDocument();
@$dom->loadHTML($html);
$xpath = new DOMXPath($dom);
//设置爬取规则
$data = $xpath->query("//a/@href");
//循环输出爬取到的数据
$result = [];
for ($i = 0; $i < $data->length; $i++) {
  // 读取节点的链接
  $href = $data->item($i)->nodeValue;
  // 规范化链接地址
  if (substr($href, 0, 1) === '/') {
    $href = $url . substr($href, 1);
  }
  // 检测是否为同一域名下
  if (strpos($href, $url) !== false) {
    $path = substr($href, strlen($url));
    // 清除?后面的内容
    if (lnString::is_exist($href, "?")) {
      $path = substr($path, 0, lnString::index($path, "?"));
    }
    if ($path == '') continue;
    // var_dump($path);
    // 路径分割
    $path_array = preg_split("/(\/|\?)/", $path);
    array_push($result, $path_array);
    // if (!isset($result[$path_array[0]]) && $path_array[0] != "") {
    //   $result[$path_array[0]] = [];
    // }
    // if (sizeof($path_array) !== 1) {
    //   array_push($result[$path_array[0]], array_slice($path_array, 1));
    // }
  }
}
// var_dump($result);
// var_dump($result);
$result = lnArray::to_tree($result);

// var_dump($result);
$result = get_tree($result);

// var_dump($_SERVER);
// if ($max_depth > 0) {
// foreach ($result as $item) {
// echo file_get_contents("http://" . $_SERVER['HTTP_HOST'] . "/test.php?url=" . substr($url, 0, -1) . $item);
// }
// }
if ($max_depth > 0) {
  echo file_get_contents("http://" . $_SERVER['HTTP_HOST'] . "/test.php?url=" . substr($url, 0, -1) . $result[0]);
}

echo json_encode($result);

function get_tree($tree, $prefix = "")
{
  $result = [];
  foreach ($tree as $key => $value) {
    if (!is_array($value)) {
      array_push($result, "{$prefix}/{$value}/");
    } else if (!is_array(current($value))) {
      array_push($result, "{$prefix}/{$key}/{$value[0]}");
    } else {
      $result = array_merge($result, get_tree($value, "{$prefix}/{$key}"));
    }
  }
  return $result;
}
