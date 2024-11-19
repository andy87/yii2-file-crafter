<?php declare(strict_types=1);

namespace app\common\components\base\controllers\core;

use yii\web\{ ErrorAction, Controller };

/**
 * < Common > Родительский класс для всех контроллеров веб-приложения
 * - BaseFrontendController
 * - BaseBackendController
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #base #controller #web
 */
abstract class BaseWebController extends Controller
{
    /** @var string */
    public const ENDPOINT = '';



    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }
}