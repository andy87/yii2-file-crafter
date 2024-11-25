<?php declare(strict_types=1);

namespace app\common\components\interfaces\services;

use app\common\components\core\repository\items\cote\CoreRepository;

/**
 * Logger Interface
 *
 * @package app\common\components\interfaces\services
 *
 * @tag: #common #interface #logger
 */
interface ServiceWithRepositoryInterface
{
    public function getRepository(string $repositoryClassName):CoreRepository;
}