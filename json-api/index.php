<?php
require_once 'shared/main.php';
include_once 'shared/unsymlink.php';
require_once 'api/shared/main.php';

header('Content-Type: application/json');

sendResponse(['apiVersion' => uupApiVersion()]);
