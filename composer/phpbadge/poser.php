<?php


require_once __DIR__ . '/vendor/autoload.php';


use PUGX\Poser\Render\SvgPlasticRender;
use PUGX\Poser\Poser;

$render = new SvgPlasticRender();
$poser = new Poser([$render]);

echo $poser->generate('license', 'MIT', '428F7E', 'plastic');
// or
echo $poser->generateFromURI('license-MIT-428F7E.svg?style=plastic');
// or
echo $poser->generateFromURI('license-MIT-428F7E?style=plastic');
// or
$image = $poser->generate('license', 'MIT', '428F7E', 'plastic');

echo $image->getStyle();