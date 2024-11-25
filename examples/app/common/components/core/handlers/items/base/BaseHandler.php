<?php declare(strict_types=1);

namespace app\common\components\core\handlers\items\base;

use app\common\components\traits\ApplyServiceTrait;
use app\common\components\core\moels\items\base\BaseModel;
use app\common\components\core\services\items\CoreItemService;
use app\common\components\interfaces\handlers\HandlerInterface;

/**
 * < Common > Родительский абстрактный класс для всех обработчиков
 *
 * @property array configService;
 * @method CoreItemService getService()
 *
 * @package app\common\components\core\handlers\items\core
 *
 * @tag: #abstract #base #handler
 */
abstract class BaseHandler implements HandlerInterface
{
    use ApplyServiceTrait;



    /** @var BaseModel|string */
    public const MODEL_CLASS = BaseModel::class;
}