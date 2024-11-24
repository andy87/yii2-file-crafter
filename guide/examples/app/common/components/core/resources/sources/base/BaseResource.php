<?php declare(strict_types=1);

namespace app\common\components\resources\source\base;

use yii\base\BaseObject;

/**
 * < Common > Base class for all resources
 *
 * @package app\common\components\resources\source\base
 *
 * @tag: #abstract #base #common #resource
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