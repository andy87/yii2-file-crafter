<?php declare(strict_types=1);

namespace app\console\handlers\items;

use app\console\components\services\items\PascalCaseService;
use app\common\components\{
    traits\ApplyServiceTrait,
    handlers\items\PascalCaseHandler as Common_PascalCaseHandler
};
use yii\base\InvalidConfigException;

/**
 * < Console > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @package app\console\components\handlers\items
 *
 * @tag #console #service #{{snake_case}}
 */
class PascalCaseHandler extends Common_PascalCaseHandler
{
    use ApplyServiceTrait;

    /**
     * @param array $configService
     */
    public array $configService = [
        'class' => PascalCaseService::class
    ];


    /**
     * @throws InvalidConfigException
     */
    public function add(array $params = [] )
    {
        return $this->getService()->add($params);
    }
}