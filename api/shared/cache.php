<?php
/*
Copyright 2022 eraseyourknees

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

   http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

class UupDumpCache {
    private $cacheFile;
    private $newCacheVersion = 1;

    public function __construct($resource, private $isCompressed = true) {
        $res = $resource."+cache_v".$this->newCacheVersion;
        $cacheHash = hash('sha256', strtolower($res));
        $ext = $isCompressed ? '.json.gz' : '.json';
        $this->cacheFile = 'cache/'.$cacheHash.$ext;
    }

    public function getFileName() {
        return $this->cacheFile;
    }

    public function delete() {
        @unlink($this->cacheFile);
    }

    public function get() {
        return false;
    }

    public function put($content, $validity) {
        return;
    }
}
