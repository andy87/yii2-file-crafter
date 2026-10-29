<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\components\services;

use yii\base\InvalidArgumentException;
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
     * Resolve a schema identifier without allowing paths or symbolic links.
     *
     * @param string $fileName Schema identifier without an extension.
     * @param bool $useAlias Whether to resolve the configured directory alias.
     * @return string Path inside the configured cache directory.
     * @throws InvalidArgumentException When the name or target is unsafe.
     */
    public function constructPath(string $fileName, bool $useAlias = true): string
    {
        if (!preg_match('/\A[a-zA-Z0-9_]+\z/', $fileName)) {
            throw new InvalidArgumentException('Invalid schema name.');
        }

        $path = parent::constructPath($fileName);
        $resolved = realpath($path);

        if (is_link($path) || ($resolved !== false && dirname($resolved) !== realpath($this->getDir()))) {
            throw new InvalidArgumentException('The schema must remain inside the cache directory.');
        }

        return parent::constructPath($fileName, $useAlias);
    }



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

            if (!str_ends_with($file, $this->getExt())) continue;

            $name = substr($file, 0, -strlen($this->getExt()));
            if (!preg_match('/\A[a-zA-Z0-9_]+\z/', $name)) continue;
            if (!is_file($this->getDir() . DIRECTORY_SEPARATOR . $file)) continue;
            if (is_link($this->getDir() . DIRECTORY_SEPARATOR . $file)) continue;

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
