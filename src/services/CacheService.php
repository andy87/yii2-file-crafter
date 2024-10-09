<?php

namespace andy87\yii2\dnk_file_crafter\services;

class CacheService
{
    private string $dir;




    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    public function getCacheFileList(): array
    {
        $list = [];

        $files = scandir($this->dir);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $list[] = $file;
        }

        return $list;
    }

    public function getCacheModelList()
    {
        $list = [];

        foreach (self::getCacheFileList() as $cacheFile) {
            $list[] = $this->getCacheModel($cacheFile);
        }

        return CollectionService::generate;
    }
}