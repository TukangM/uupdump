<?php
function checkIfUserIsRateLimited($resource, $timeLimit = 10, $currentResLimit = 1) {
    $clientIP = $_SERVER['REMOTE_ADDR'];
    $ipHash = hash('sha256', "ratelimits-$clientIP");

    $info = @file_get_contents('cache/'.$ipHash.'.json');
    $info = json_decode($info, 1);

    if(!isset($info['resource'])) {
        $info['resource'] = $resource;
    }

    if(!isset($info['lastAccess'])) {
        $info['lastAccess'] = 0;
    }

    $lastAccess = $info['lastAccess'];
    $accessedRes = $info['resource'];
    $blockAccessTime = $lastAccess + $timeLimit;

    if($blockAccessTime > microtime(1) && $accessedRes != $resource) {
        return true;
    }

    $info['lastAccess'] = microtime(1);
    $info['resource'] = $resource;

    @file_put_contents('cache/'.$ipHash.'.json', json_encode($info)."\n");

    if($lastAccess + $currentResLimit > microtime(1) && $accessedRes == $resource) {
        return true;
    }

    return false;
}
