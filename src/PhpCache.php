<?php

namespace Jackdou\PhpFmt;

class PhpCache
{
    private $cacheFile = __DIR__ . "/cache/cache.txt";

    private $caches;

    public function __construct()
    {

        if (!file_exists($this->cacheFile)) {

            file_put_contents($this->cacheFile, '');

        } else {

            $this->caches = (array)json_decode(file_get_contents($this->cacheFile));
        }
    }

    /**
     * @param string $file
     * @param int $mtime
     */
    public function setCache(string $file, int $mtime)
    {
        $this->caches[$file] = $mtime;
    }

    /**
     * @param string $file
     * @return int
     */
    public function getCache(string $file) :int
    {
        return !empty($this->caches[$file]) ? $this->caches[$file] : 0;
    }

    /**
     * 缓存落地
     */
    public function __destruct()
    {
        if (!empty($this->caches)) {
            file_put_contents($this->cacheFile, json_encode($this->caches));
        }
    }
}
