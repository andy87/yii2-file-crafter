<?php declare(strict_types=1);

namespace app\common\components\base\handlers\items;

use app\common\components\base\handlers\items\core\BaseHandler;

/**
 * < Common > Родительский абстрактный класс для всех Web обработчиков
 *
 * @package app\common\components\base\handlers\itemse
 *
 * @tag: #base #handlers
 */
abstract class WebHandler extends BaseHandler
{
    /** @var array */
    public array $resources;
}