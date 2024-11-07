<?php

namespace andy87\yii2\file_crafter\components\services;

use andy87\yii2\file_crafter\components\{core\CoreGenerator};

/**
 * Class CacheService
 *
 * @package andy87\yii2\file_crafter\components\services
 *
 * @tag: #service #cache
 */
class CacheService extends DirectoryProviderService
{
    /** @var string Default cache dir */
    public const DEFAULT_DIR = CoreGenerator::DEFAULT_RESOURCES_DIR . DIRECTORY_SEPARATOR . 'cache';

    /** @var string Default cache ext */
    public const DEFAULT_EXT = '.json';



    /**
     * Collect all cache files
     *
     * @return array
     */
    public function getCacheFileList(): array
    {
        $list = [];

        $files = scandir($this->getDir());

        foreach ($files as $file)
        {
            if ($file === '.' || $file === '..') continue;

            if (preg_match('/[^\w\_\.]/', $file)) continue;

            $list[] = $file;
        }

        return $list;
    }

    /**
     * Get content from cache file
     *
     * @param mixed $tableName
     *
     * @return ?string
     */
    public function getContentCacheFile(mixed $tableName): ?string
    {
        $pathCache = $this->constructPath($tableName);

        if (file_exists($pathCache))
        {
            $content = file_get_contents($pathCache);

            if (strlen($content))
            {
                return $content;
            }
        }

        return null;
    }

    /**
     * Remove cache file
     *
     * @param string $remove
     *
     * @return void
     */
    public function removeItem(string $remove): void
    {
        $pathCache = $this->constructPath($remove);

        if (file_exists($pathCache))
        {
            unlink($pathCache);
        }
    }
}