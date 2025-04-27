<?php

Basic::route('ANY', '/api/jsonrpc', function () {
    Basic::setJsonRpc(); // JSON-RPC endpoint
});

Basic::route('ANY', '/api/httprpc', function () {
    Basic::setHttpRpc(); // RPC over HTTP
});

Basic::route('POST', '/api/request', function () {
    // $data as an array of name and age
    $data = array();
    $data[] = ['name' => 'John', 'age' => 32];
    $data[] = ['name' => 'Peter', 'age' => 43];
    $data[] = ['name' => 'James', 'age' => 22];
    $data[] = ['name' => 'Samuel', 'age' => 28];
    $data[] = ['name' => 'Joseph', 'age' => 65];

    // Convert JSON POST body as an array
    $body = json_decode(file_get_contents("php://input"), TRUE);

    // Check Authorization Bearer token
    if ($_SERVER['HTTP_AUTHORIZATION'] !== 'Bearer ' . AUTH_TOKEN)
        Basic::apiResponse(403, 'You do not have the right credentials.');

    $data_output = array();
    foreach ($data as $row) {
        // Add to $data_output array if name contains search string
        if (stristr($row['name'], $body['search']) == TRUE) {
            // Change $data_output key names to hide database column names
            $data_output[] = ['name' => $row['name'], 'age' => $row['age']];
        }
    }

    if (empty($data_output))
        Basic::apiResponse(400, 'No name found on search.');

    Basic::apiResponse(200, $data_output, 'application/json');
});