<?php declare(strict_types=1);

namespace app\common\components\base\controllers\items;

use yii\web\ErrorAction;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\common\components\enums\Action;
use app\common\components\base\moels\items\source\SourceModel;
use app\common\components\base\controllers\items\source\SourceWebController;

/**
 * < Common > Родительский класс для всех контроллеров веб-приложения
 * - BaseFrontendController
 * - BaseBackendController
 *
 * @package app\common\components\base\controllers
 *
 * @tag: #abstract #common #base #controller #items #web
 */
abstract class BaseWebController extends SourceWebController
{
    /**
     * Первый сегмент URL для обращения к контроллеру
     *
     * Обычно совпадает с именем контроллера в кебаб-кейсе
     *
     * @example Для контроллера `UserGroupController` будет `user-group`
     *
     * @var string
     */
    public const ENDPOINT = '';



    /**
     * Массив с доступными действиями и методами для них
     *
     * Переопределяются в дочерних контроллерах согласно необходимым методам
     *
     * @var array
     */
    public const VERBS = [
        Action::INDEX => ['GET'],
        Action::VIEW => ['GET'],
        Action::CREATE => ['GET', 'POST'],
        Action::UPDATE => ['GET', 'POST'],
        Action::DELETE => ['DELETE'],
    ];



    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        // @ - Authorized
                        // ? - Guest
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => static::VERBS,
            ],
        ];
    }
}