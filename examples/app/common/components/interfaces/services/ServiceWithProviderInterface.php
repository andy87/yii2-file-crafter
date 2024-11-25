<?php declare(strict_types=1);

namespace app\common\components\interfaces\services;

use app\common\components\core\providers\items\base\CoreProducer;

/**
 * Logger Interface
 *
 * @package app\components\interfaces\services
 *
 * @tag: #common #interface #logger
 */
interface ServiceWithProviderInterface
{
    public function getProvider( string $providerClassName ): CoreProducer;
}