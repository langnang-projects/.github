<?php
$app = require_once __DIR__ . '/bootstrap/app.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PhpInfo</title>
  <style>
    body {
      background-color: #fff;
      color: #222;
      font-family: sans-serif;
    }

    pre {
      margin: 0;
      font-family: monospace;
    }

    a:link {
      color: #009;
      text-decoration: none;
      background-color: #fff;
    }

    a:hover {
      text-decoration: underline;
    }

    table {
      border-collapse: collapse;
      border: 0;
      width: 1200px !important;
      box-shadow: 1px 2px 3px #ccc;
    }

    .center {
      text-align: center;
    }

    .center table {
      margin: 1em auto;
      text-align: left;
    }

    .center th {
      text-align: center !important;
    }

    td,
    th {
      border: 1px solid #666;
      font-size: 75%;
      vertical-align: baseline;
      padding: 4px 5px;
    }

    h1 {
      font-size: 150%;
    }

    h2 {
      font-size: 125%;
    }

    .p {
      text-align: left;
    }

    .e {
      background-color: #ccf;
      width: 300px;
      font-weight: bold;
    }

    .h {
      background-color: #99c;
      font-weight: bold;
    }

    .v {
      background-color: #ddd;
      max-width: 300px;
      overflow-x: auto;
      word-wrap: break-word;
    }

    .v i {
      color: #999;
    }

    img {
      float: right;
      border: 0;
    }

    hr {
      width: 934px;
      background-color: #ccc;
      border: 0;
      height: 1px;
    }

    thead {
      cursor: pointer;
    }

    .d-none {
      display: none;
    }
  </style>
  <script>
    window.onload = function() {
      const thead = document.getElementsByTagName("thead");
      const tbody = document.getElementsByTagName("tbody");
      // console.log(thead,tbody);
      Array.from(thead).forEach(function(head) {
        head.addEventListener("click", function() {
          const body = head.nextElementSibling;
          const visible = !(new RegExp(" d-none ").test(" " + body.className + " "));
          if (visible) {
            body.classList.add("d-none");
          } else {
            body.classList.remove("d-none")
          }
        })
      })
      // Array.from(tbody).forEach(function(body){
      //   body.classList.add("d-none");
      // })

    }
  </script>
</head>

<body>
  <div class="center">
    <table>
      <tbody>
        <tr class="h">
          <td>
            <a href="http://www.php.net/"><img border="0" src="data:image/png;base64,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" alt="PHP logo"></a>
            <h1 class="p">PHP Version <?php _e(phpversion()) ?></h1>
            <p>
              PHP Version <?php _e(phpversion()) ?>.
              Load Time <?php _e(round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 5)); ?> Sec.
              Page Size <?php _e(round(ob_get_length() / 1024, 5)); ?> KB.
            </p>
          </td>
        </tr>
      </tbody>
    </table>

    <h1> PHP Server </h1>
    <table>
      <tbody>
        <?php foreach ($_SERVER as $key => $value) {
          if ($key == 'Path') $value = implode(";<br/>", explode(";", $value));
          echo "<tr><td class=\"e\">$key</td><td class=\"v\">$value</td><td class=\"v\"></td></tr>";
        }
        ?>
      </tbody>
    </table>

    <h1> User Function </h1>

    <table>
      <tbody>
        <?php foreach (get_defined_functions()['user'] as $alias => $method) {
          echo "<tr><td class=\"e\">$method</td><td class=\"v\"></td><td class=\"v\"></td></tr>";
        }
        unset($alias, $method);
        ?>
      </tbody>
    </table>

    <h1> Illuminates </h1>

    <?php
    echo "<a href='#Illuminate.$app->name'><h2 id='Illuminate.$app->name'>" . $app->alias . ' => ' . $app->name . "</h2></a>";
    $vars = array_filter(array_keys(get_class_vars(get_class($app))), function ($var) {
      return !preg_match("/^_/", $var);
    });
    echo "<table><thead><tr class='h'><th colspan='2'> Vars (" . sizeof($vars) . ") </th><th> Local Value </th><th> Annotation </th></tr></thead><tbody class='d-none'>";
    foreach ($vars as $var) {
      echo "<tr><td class=\"e\">$var</td><td class=\"v\">" . gettype($app->{$var}) . "</td><td class=\"v\">" . json_encode($app->{$var}) . "</td><td class=\"v\"></td></tr>";
    }
    unset($vars, $var);
    echo "</tbody></table>";

    // methods
    $methods = array_filter(get_class_methods($app), function ($method) {
      // var_dump($method);
      return !preg_match("/^_/", $method);
    });
    echo "<table><thead><tr class='h'><th colspan='2'> Methods (" . sizeof($methods) . ") </th><th> Annotation </th></tr></thead><tbody class='d-none'>";
    foreach ($methods as $method) {
      echo "<tr><td class=\"e\">$method</td><td class=\"v\"></td><td class=\"v\"></td></tr>";
    }
    // if (count($methods) > 0) {

    // echo '<td class="e">' . implode(", ", $methods) . '</td>';
    // foreach (array_values($methods) as $alias => $method) {
    //   if (preg_match("/^_/", $method)) continue;
    //   echo "<tr><td class=\"e\">$alias</td><td class=\"v\">$method</td></tr>";
    // }
    // }
    unset($methods, $method);
    echo "</tbody></table>";
    // aliases
    echo "<table><thead><tr class='h'><th colspan='2'> Aliases (" . sizeof($app->get_aliases()) . ") </th><th> Annotation </th></tr></thead><tbody class='d-none'>";
    // echo '<tr class="h"><th>memcache support</th><th>enabled</th></tr>';
    foreach ($app->get_aliases() as $alias => $illuminate) {
      if (empty($illuminate)) {
        var_dump($alias);
        continue;
      }
      echo "<tr><td class=\"e\">$illuminate->name</td><td class=\"v\">$alias</td><td class=\"v\"></td></tr>";
    }
    unset($alias, $illuminate);
    echo "</tbody></table>";
    // facades
    echo "<table><thead><tr class='h'><th colspan='2'> Facades (" . sizeof($app->get_facades()) . ") </th><th> Annotation </th></tr></thead><tbody class='d-none'>";
    foreach ($app->get_facades() as $alias => $facade) {
      echo "<tr><td class=\"e\">$alias</td><td class=\"v\">$facade</td><td class=\"v\"></td></tr>";
    }
    unset($alias, $illuminate);
    echo "</tbody></table>";


    foreach ($app->get_aliases() as $alias => $illuminate) {
      echo "<a href='#Illuminate.$illuminate->name'><h2 id='Illuminate.$illuminate->name'>" . $alias . ' => ' . $illuminate->name . "</h2></a>";
      $vars = array_filter(array_keys(get_class_vars(get_class($illuminate))), function ($var) {
        return !preg_match("/^_/", $var);
      });
      echo "<table><thead><tr class='h'><th colspan='2'> Vars (" . sizeof($vars) . ") </th><th> Local Value </th><th> Annotation </th></tr></thead><tbody class='d-none'>";
      foreach ($vars as $var) {
        echo "<tr><td class=\"e\">$var</td><td class=\"v\">" . gettype($illuminate->{$var}) . "</td><td class=\"v\">" . json_encode($illuminate->{$var}) . "</td><td class=\"v\"></td></tr>";
      }
      unset($vars, $var);
      echo "</tbody></table>";

      switch ($alias) {
        case "config":
          // aliases
          echo "<table><thead><tr class='h'><th colspan='2'> Aliases (" . sizeof($illuminate->all()) . ") </th><th> Annotation </th></tr></thead><tbody class='d-none'>";
          // echo '<tr class="h"><th>memcache support</th><th>enabled</th></tr>';
          foreach ($illuminate->all() as $alias => $aliasValue) {
            if (empty($aliasValue)) {
              var_dump($alias);
              continue;
            }
            echo "<tr><td class=\"e\">$alias</td><td class=\"v\"></td><td class=\"v\"></td></tr>";
          }
          unset($alias, $aliasValue);
          echo "</tbody></table>";
          // aliases
          break;
        case "modular":
          // aliases
          echo "<table><thead><tr class='h'><th colspan='2'> Aliases (" . sizeof($illuminate->get()) . ") </th><th> Annotation </th></tr></thead><tbody class='d-none'>";
          // echo '<tr class="h"><th>memcache support</th><th>enabled</th></tr>';
          foreach ($illuminate->get() as $alias => $aliasValue) {
            if (empty($aliasValue)) {
              var_dump($alias);
              continue;
            }
            echo "<tr><td class=\"e\">$alias</td><td class=\"v\"></td><td class=\"v\"></td></tr>";
          }
          unset($alias, $aliasValue);
          echo "</tbody></table>";
          break;
        case "router":
          // aliases
          echo "<table><thead><tr class='h'><th colspan='2'> Routes (" . sizeof($illuminate->getRoutes()) . ") </th><th> Annotation </th></tr></thead><tbody class='d-none'>";
          // echo '<tr class="h"><th>memcache support</th><th>enabled</th></tr>';
          foreach ($illuminate->getRoutes() as $alias => $aliasValue) {
            if (empty($aliasValue)) {
              var_dump($alias);
              continue;
            }
            echo "<tr><td class=\"e\">$alias</td><td class=\"v\"></td><td class=\"v\"></td></tr>";
          }
          unset($alias, $aliasValue);
          echo "</tbody></table>";
          break;
        default:
          break;
      }


      // methods
      $methods = array_filter(get_class_methods($illuminate), function ($method) {
        // var_dump($method);
        return !preg_match("/^_/", $method);
      });
      echo "<table><thead><tr class='h'><th colspan='2'> Methods (" . sizeof($methods) . ") </th><th> Annotation </th></tr></thead><tbody class='d-none'>";
      foreach ($methods as $method) {
        echo "<tr><td class=\"e\">$method</td><td class=\"v\"></td><td class=\"v\"></td></tr>";
      }
      // if (count($methods) > 0) {

      // echo '<td class="e">' . implode(", ", $methods) . '</td>';
      // foreach (array_values($methods) as $alias => $method) {
      //   if (preg_match("/^_/", $method)) continue;
      //   echo "<tr><td class=\"e\">$alias</td><td class=\"v\">$method</td></tr>";
      // }
      // }
      unset($methods, $method);
      echo "</tbody></table>";
    }
    ?>

    <h1> Configuration </h1>

    <?php
    foreach (get_loaded_extensions() as $extension) {
      echo "<a href='#Configuration.$extension'><h2 id='Configuration.$extension'>" . $extension . "</h2></a>";
      // methods
      $methods = get_extension_funcs($extension) ?: [];
      echo "<table><thead><tr class='h'><th colspan='2'> Methods (" . sizeof($methods) . ") </th><th> Annotation </th></tr></thead><tbody class='d-none'>";

      // echo '<td class="e">' . implode(", ", get_extension_funcs($extension) ?: [])  . '</td>';
      foreach ($methods as $alias => $method) {
        echo "<tr><td class=\"e\">$method</td><td class=\"v\"></td><td class=\"v\"></td></tr>";
      }
      // foreach (array_values($methods) as $alias => $method) {
      //   if (preg_match("/^_/", $method)) continue;
      //   echo "<tr><td class=\"e\">$alias</td><td class=\"v\">$method</td></tr>";
      // }
      // unset($methods, $alias, $method);
      echo "</tbody></table>";
    }

    ?>

  </div>
</body>

</html>