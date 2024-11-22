<?php declare(strict_types=1);

namespace app\common\components\base\controllers\core;

use yii\web\Controller;
use app\common\components\{ traits\ApplyServiceTrait, base\services\items\ItemService };

/**
 * < Common > Родительский класс для всех контроллеров с сервисом
 *
 * @property ItemService $service
 * @property ItemService|string $classnameService
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #base #controller #web
 */
abstract class BaseServiceController extends Controller
{
    /**
     * Трейт для применения сервиса
     */
    use ApplyServiceTrait;

    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();

        $this->setupService();
    }
}