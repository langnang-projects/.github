<?php
$packages = read_packages(getcwd() . "/vendor/*", 2);


function read_packages($dir, $depth = -1)
{
    $return = [];
    // var_dump([$dir, $depth]);
    foreach (glob($dir) as $file) {
        if ($file != "." && $file != "..") {
            if (is_dir($file)) {
                // echo "目录：" . $file . "<br/>";
                // array_push($return, pathinfo($file));
                array_push($return, $file);
                if ($depth == -1) {
                    $return = array_merge($return, read_packages($file . "/*"));
                } else if ($depth > 1) {
                    $return = array_merge($return, read_packages($file . "/*", $depth - 1));
                }
            } else {
                // echo "文件：" . $file . "<br/>";
            }
        }
    }
    return $return;
}
$packages = array_filter(array_map(function ($item) {
    return [
        'path' => $item,
        'name' => substr($item, strlen(getcwd() . '/vendor/')),
    ];
}, $packages), function ($item) {
    return stripos($item['name'], '/') > 0;
});
// var_dump(getcwd());
// var_dump($packages);
// myglob(getcwd() . "/vendor/*", 1);
function mydir($dir)
{
    $d = dir($dir);
    while (($file = $d->read()) !== false) {
        if ($file != "." && $file != "..") {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                echo "目录：" . $dir . DIRECTORY_SEPARATOR . $file . "<br/>";
                mydir($dir . DIRECTORY_SEPARATOR . $file);
            } else {
                echo "文件：" . $dir . DIRECTORY_SEPARATOR . $file . "<br/>";
            }
        }
    }
    $d->close();
}
function myreaddir($dir)
{
    $hander = opendir($dir);
    if ($hander) {
        while (($file = readdir($hander)) != false) {
            if ($file != "." && $file != "..") {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                    echo "目录：" . $dir . DIRECTORY_SEPARATOR . $file . "<br/>";
                    // myreaddir($dir . DIRECTORY_SEPARATOR . $file . DIRECTORY_SEPARATOR);
                } else {
                    echo "文件：" . $dir . $file . "<br/>";
                }
            }
        }
    }
    closedir($hander);
}
function myglob($dir, $depth = -1)
{
    foreach (glob($dir) as $file) {
        if ($file != "." && $file != "..") {
            if (is_dir($file)) {
                echo "目录：" . $file . "<br/>";
                myglob($file . "/*");
            } else {
                echo "文件：" . $file . "<br/>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GUI</title>
</head>

<body>
    <div>
        <header></header>
        <aside></aside>
        <main></main>
        <footer></footer>
    </div>
</body>

</html>