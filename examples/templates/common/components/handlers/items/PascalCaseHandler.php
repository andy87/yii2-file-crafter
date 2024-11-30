<?php declare(strict_types=1);

namespace app\common\components\handlers\items;

use app\common\models\items\PascalCase;
use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\base\handlers\items\source\SourceHandler;

/**
 * < Common > Родительский класс для обработчиков: console/frontend/backend
 *
 * @package app\app\common\services\components\handlers\items
 *
 * @tag: #boilerplate #common #service #{{snake_case}}
 */
class PascalCaseHandler extends SourceHandler
{
    /** @var SourceModel|string */
    public const MODEL_CLASS = PascalCase::class;

    // {{Boilerplate}}
}