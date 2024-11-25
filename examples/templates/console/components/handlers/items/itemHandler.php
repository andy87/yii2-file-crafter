<?php declare(strict_types=1);

namespace console\components\handlers\items;

use app\common\components\{traits\ApplyServiceTrait};
use common\components\handlers\items\PascalCaseHandler as Common_PascalCaseHandler;
use console\components\services\items\PascalCaseService;
use console\models\items\PascalCase;
use Exception;
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
        'class' => PascalCaseService::class,
        'modelClass' => \console\models\items\PascalCase::class
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
     * @return ?\console\models\items\PascalCase
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
    private function findByID( int $id ): ?\console\models\items\PascalCase
    {
        return $this->getService()->fi($id);
    }
}