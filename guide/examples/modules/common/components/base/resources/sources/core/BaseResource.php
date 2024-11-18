<?php declare(strict_types=1);

namespace app\components\common\components\base\resources;

use yii\base\BaseObject;

/**
 * < Common > Base class for all resources
 *
 * @package app\common\components\base\resources
 *
 * @tag: #base #resource
 */
abstract class BaseResource extends BaseObject
{
    /** @var string Key for the release method */
    public const KEY = 'R';



    /**
     * @return array
     */
    public function release(): array
    {
        return [ self::KEY => (array) $this ];
    }
}