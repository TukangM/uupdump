<?php
require_once 'shared/main.php';
require_once 'shared/ratelimits.php';
include_once 'shared/unsymlink.php';
require_once 'api/get.php';

$updateId = isset($_GET['id']) ? $_GET['id'] : null;
$usePack = isset($_GET['lang']) ? $_GET['lang'] : 0;
$desiredEdition = isset($_GET['edition']) ? $_GET['edition'] : 0;
$noLinks = isset($_GET['noLinks']) ? $_GET['noLinks'] : 0;

header('Content-Type: application/json');

$edition = is_array($desiredEdition) ? implode('_', $desiredEdition) : $desiredEdition;
$resource = hash('sha1', strtolower("get-$updateId-$usePack-$edition"));
if(checkIfUserIsRateLimited($resource) && !$noLinks) {
    http_response_code(429);
    sendResponse(['error' => 'USER_RATE_LIMITED']);
    die();
}

$mode = $noLinks ? 2 : 1;
$apiResponse = uupGetFiles($updateId, $usePack, $desiredEdition, $mode);
if(isset($apiResponse['error'])) {
    switch($apiResponse['error']) {
        case 'NO_FILES':
            http_response_code(500);
            break;

        case 'XML_PARSE_ERROR':
            http_response_code(500);
            break;

        case 'EMPTY_FILELIST':
            http_response_code(500);
            break;

        default:
            http_response_code(400);
    }
}

sendResponse($apiResponse);
