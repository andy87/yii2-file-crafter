<?php declare(strict_types=1);

namespace app\common\components\base\handlers\items\core;

use app\common\components\{
    base\resources\sources\BaseTemplateResource,
    base\services\items\ModelService,
    interfaces\handlers\HandlerInterface
};

/**
 * < Common > Родительский абстрактный класс для всех обработчиков
 *
 * @package app\common\components\base\handlers\items\core
 *
 * @tag: #base #handlers
 */
abstract class BaseHandler implements HandlerInterface
{
    /** @var ModelService */
    public ModelService $service;

    public array $resources = [
        null => BaseTemplateResource::class,
    ];



    /**
     * @param string $action
     *
     * @return BaseTemplateResource|string
     */
    private function getResources( string $action ): BaseTemplateResource|string
    {
        return $this->resources[$action] ?? $this->resources[null];
    }
}