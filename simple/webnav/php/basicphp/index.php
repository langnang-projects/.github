<?php

/*
|--------------------------------------------------------------------------
| Configuration - Constants and Variables
|--------------------------------------------------------------------------
*/

define('DB_NAME', 'basicphp'); // Sample database name
define('DB_USER', 'user'); // Sample database username
define('DB_PASS', 'pass'); // Sample database password

define('PASS_PHRASE', 'SecretPassPhrase123'); // Passphrase or KEK API URL
define('AUTH_TOKEN', 'encv1.VWZUSXNEUVdQVmlPbnVVTVRDZkxibC9aM3YwT21raVhpdXRBNGZoR1dsUjllUT09.iJPEzvBUYueIhg0c8VD5Ag==.a1ycb+X3teBNAlAjQAQe/w=='); // Authorization Bearer token

/*
|--------------------------------------------------------------------------
| Load BasicPHP Class Library
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/app/Basic.php';

/*
|--------------------------------------------------------------------------
| Middleware
|--------------------------------------------------------------------------
*/

Basic::setErrorReporting(); // Error reporting
// Basic::setJsonBodyAsPOST(); // JSON as $_POST
Basic::setFirewall(); // Enable firewall
// Basic::setHttps(); // Require TLS/HTTPS

// setcookie('token', Basic::encrypt('{"username":"user","role":"admin"}', PASS_PHRASE), NULL, NULL, NULL, NULL, TRUE); // Sample token
// var_dump(json_decode(Basic::decrypt($_COOKIE['token'], PASS_PHRASE), TRUE));

Basic::setAutoloadClass(['classes', 'models', 'views', 'controllers']); // Autoload folders
Basic::setAutoRoute(); // Automatic '/class/method' routing

// var_dump($_SERVER);
// echo "<script>console.log(" . json_encode($_SERVER, true) . ")</script>";
// echo "<script>console.log(123)</script>";
/*
|--------------------------------------------------------------------------
| Endpoint Routes
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/routes/api.php';
require_once __DIR__ . '/routes/web.php';




/*
|--------------------------------------------------------------------------
| Handle Error 404 - Page Not Found - Invalid URI
|--------------------------------------------------------------------------
*/

Basic::apiResponse(404); // Not Found

