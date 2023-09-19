<?php
require_once 'shared/main.php';
include_once 'shared/unsymlink.php';
require_once 'api/listlangs.php';

$updateId = isset($_GET['id']) ? $_GET['id'] : null;

header('Content-Type: application/json');

$apiResponse = uupListLangs($updateId);
if(isset($apiResponse['error']))
    http_response_code(400);

sendResponse($apiResponse);
