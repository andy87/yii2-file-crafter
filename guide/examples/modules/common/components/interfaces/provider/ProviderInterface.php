<?php declare(strict_types=1);

namespace app\common\components\interfaces\provider;

use app\common\components\base\moels\items\core\BaseModel;

/**
 * Provider Interface
 *
 * @package app\common\components\interfaces\provider
 *
 * @tag: #base #interface #provider
 */
interface ProviderInterface
{
    public function create( array $params, bool $runSave = false ): ?BaseModel;

    public function add( array $params ): ?BaseModel;
}