<?php declare(strict_types=1);

namespace app\common\components\interfaces\services;

use app\common\components\base\repository\items\cote\BaseRepository;

/**
 * Logger Interface
 *
 * @package app\common\components\interfaces\services
 *
 * @tag: #base #interface #logger
 */
interface ServiceWithRepositoryInterface
{
    public function getRepository(string $repositoryClassName):BaseRepository;
}