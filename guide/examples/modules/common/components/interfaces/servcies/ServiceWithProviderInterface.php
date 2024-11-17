<?php declare(strict_types=1);

namespace interfaces\servcies;

use app\common\components\base\providers\items\core\BaseProvider;

/**
 * Logger Interface
 *
 * @package app\common\components\interfaces
 *
 * @tag: #base #interface #logger
 */
interface ServiceWithProviderInterface
{
    public function getProvider( string $providerClassName ): BaseProvider;
}