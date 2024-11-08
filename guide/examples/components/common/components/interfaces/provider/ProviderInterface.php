<?php declare(strict_types=1);

namespace interfaces\provider;

use base\moels\items\core\BaseModel;

/**
 * Provider Interface
 *
 * @package app\common\components\interfaces
 *
 * @tag: #base #interface #provider
 */
interface ProviderInterface
{
    public function create( array $params, bool $runSave = false ): ?BaseModel;

    public function add( array $params ): ?BaseModel;
}