<?php
require_once 'shared/main.php';
include_once 'shared/unsymlink.php';
require_once 'api/listid.php';

$search = isset($_GET['search']) ? $_GET['search'] : null;
$sortByDate = isset($_GET['sortByDate']) ? $_GET['sortByDate'] : false;

header('Content-Type: application/json');

$apiResponse = uupListIds($search, $sortByDate);
if(isset($apiResponse['error']))
    http_response_code(400);

sendResponse($apiResponse);
