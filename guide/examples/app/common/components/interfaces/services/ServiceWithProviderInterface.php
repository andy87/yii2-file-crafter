<?php declare(strict_types=1);

namespace app\components\interfaces\services;

use app\common\components\base\providers\items\core\BaseProvider;

/**
 * Logger Interface
 *
 * @package app\components\interfaces\services
 *
 * @tag: #base #interface #logger
 */
interface ServiceWithProviderInterface
{
    public function getProvider( string $providerClassName ): BaseProvider;
}