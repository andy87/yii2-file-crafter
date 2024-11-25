<?php declare(strict_types=1);

namespace app\common\components\handlers\items;

use app\common\models\items\PascalCase;
use app\common\components\core\moels\items\base\BaseModel;
use app\common\components\core\handlers\items\base\BaseHandler;

/**
 * < Common > Родительский класс для обработчиков: console/frontend/backend
 *
 * @package app\app\common\services\components\handlers\items
 *
 * @tag #common #service #{{snake_case}}
 */
class PascalCaseHandler extends BaseHandler
{
    /** @var BaseModel|string */
    public const MODEL_CLASS = PascalCase::class;

    // {{Boilerplate}}
}