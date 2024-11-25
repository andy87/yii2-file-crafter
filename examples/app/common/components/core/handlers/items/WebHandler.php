<?php declare(strict_types=1);

namespace app\common\components\core\handlers\items;

use app\common\components\core\handlers\items\base\BaseHandler;
use app\common\components\core\services\items\CoreModelService;
use app\common\components\core\resources\sources\CoreTemplateResource;

/**
 * < Common > Родительский абстрактный класс для всех Web обработчиков
 *
 * @property CoreModelService $service;
 *
 * @package app\common\components\core\handlers\itemse
 *
 * @tag: #abstract #core #handler #web
 */
abstract class WebHandler extends BaseHandler
{
    /**
     * Массив с ресурсами для контроллера
     *
     * Переопределяются в дочерних контроллерах согласно имени модели с которой работает контроллер
     *
     * @example Для модели `UserRole` работающей с таблицей `user_role`
     * ```php
     *  public const RESOURCES = [
     *       Action::INDEX => UserRoleGridViewResource::class,
     *       Action::VIEW => UserRoleViewResource::class,
     *       Action::CREATE => UserRoleCreateResource::class,
     *       Action::UPDATE => UserRoleUpdateResource::class,
     *  ];
     *
     * @var array
     */
    public array $resources = [
        null => CoreTemplateResource::class,
    ];



    /**
     * @param string $action
     *
     * @return CoreTemplateResource|string
     */
    private function getResources( string $action ): CoreTemplateResource|string
    {
        return $this->resources[$action] ?? $this->resources[null];
    }
}