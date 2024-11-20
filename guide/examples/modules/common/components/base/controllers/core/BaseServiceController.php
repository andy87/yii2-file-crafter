<?php declare(strict_types=1);

namespace app\common\components\base\controllers\core;

use yii\web\Controller;
use app\common\components\base\services\items\ItemService;

/**
 * < Common > Родительский класс для всех контроллеров с сервисом
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #base #controller #web
 */
abstract class BaseServiceController extends Controller
{
    /** @var ItemService $service */
    protected ItemService $service;
}