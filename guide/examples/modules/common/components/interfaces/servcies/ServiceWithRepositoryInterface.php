<?php declare(strict_types=1);

namespace interfaces\servcies;

use app\common\components\base\repository\items\cote\BaseRepository;

/**
 * Logger Interface
 *
 * @package app\common\components\interfaces
 *
 * @tag: #base #interface #logger
 */
interface ServiceWithRepositoryInterface
{
    public function getRepository(string $repositoryClassName):BaseRepository;
}