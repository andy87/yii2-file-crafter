<?php declare(strict_types=1);

namespace app\common\components\interfaces\providers;

use app\common\components\core\moels\items\base\BaseModel;

/**
 * Provider Interface
 *
 * @package app\common\components\interfaces\provider
 *
 * @tag: #common #interface #provider
 */
interface ProviderInterface
{
    public function create( array $params, bool $runSave = false ): ?BaseModel;

    public function add( array $params ): ?BaseModel;
}