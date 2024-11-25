<?php declare(strict_types=1);

namespace app\console\components\handlers\parents;

use app\common\components\core\moels\items\base\BaseModel;
use app\common\components\core\handlers\items\base\BaseHandler;

/**
 * < Console > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @package app\console\components\handlers\parents
 *
 * @tag #abstract #console #core #handler
 */
abstract class ConsoleHandler extends BaseHandler
{
    //TODO: Доделать обработчик
    public function processIndex(): array
    {

    }

    //TODO: Доделать обработчик
    public function processCreate(): ?BaseModel
    {

    }

    //TODO: Доделать обработчик
    public function processUpdate(): ?BaseModel
    {

    }

    //TODO: Доделать обработчик
    public function processView(): ?BaseModel
    {

    }

    //TODO: Доделать обработчик
    public function processDelete(): int
    {

    }
}