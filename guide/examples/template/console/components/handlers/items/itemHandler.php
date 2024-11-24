<?php declare(strict_types=1);

namespace app\console\handlers\items;

use Exception;
use yii\base\InvalidConfigException;
use app\console\models\items\PascalCase;
use app\console\components\services\items\PascalCaseService;
use app\common\components\{
    traits\ApplyServiceTrait,
    handlers\items\PascalCaseHandler as Common_PascalCaseHandler
};

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
        'class' => PascalCaseService::class,
        'modelClass' => PascalCase::class
    ];


    /**
     * @throws InvalidConfigException|Exception
     */
    public function add(array $params = [] )
    {
        return $this->getService()->add($params);
    }

    /**
     * @param int $id
     *
     * @return ?PascalCase
     *
     * @throws InvalidConfigException
     */
    public function view( int $id ): ?PascalCase
    {
        return $this->findByID($id);
    }

    /**
     * @throws InvalidConfigException
     */
    private function findByID( int $id ): ?PascalCase
    {
        return $this->getService()->fi($id);
    }
}