<?php declare(strict_types=1);

namespace app\console\components\handlers\items;

use yii\base\InvalidConfigException;
use app\console\models\items\PascalCase;
use app\common\components\traits\ApplyServiceTrait;
use app\console\components\services\items\PascalCaseService;
use app\console\components\provider\items\PascalCaseProvider;
use app\console\components\repository\items\PascalCaseRepository;

/**
 * < Console > Обработчик контроллеров работающих с сущностью `{{PascalCase}}`
 *
 * @method PascalCaseService getService()
 *
 * @package app\console\components\handlers\items
 *
 * @tag #console #service #{{snake_case}}
 */
class PascalCaseHandler extends \app\common\components\handlers\items\PascalCaseHandler
{
    use ApplyServiceTrait;


    public const MODEL_CLASS = PascalCase::class;



    /**
     * @param array $configService
     */
    public array $configService = [
        'class' => PascalCaseService::class,
        'modelClass' => self::MODEL_CLASS,
        'configProvider' => [
            'class' => PascalCaseProvider::class,
            'modelClass' => self::MODEL_CLASS,
        ],
        'configRepository' => [
            'class' => PascalCaseRepository::class,
            'modelClass' => self::MODEL_CLASS,
        ],
    ];



    /**
     * @param int $id
     *
     * @return ?PascalCase
     *
     * @throws InvalidConfigException
     */
    public function processView( int $id ): ?PascalCase
    {
        return $this->findByID($id);
    }

    /**
     * @throws InvalidConfigException
     */
    public function processAdd(int $id ): ?PascalCase
    {
        return $this->findByID($id);
    }

    /**
     * @throws InvalidConfigException
     */
    public function processUpdate(int $id, array $params ): ?PascalCase
    {
        $model = $this->findByID($id);

        $model->load($params, '');

        return $this->findByID($id);
    }

    /**
     * @throws InvalidConfigException
     */
    public function processDelete(int $id ): ?PascalCase
    {
        return $this->findByID($id);
    }

    /**
     * @throws InvalidConfigException
     */
    private function findByID( int $id ): ?PascalCase
    {
        return $this->getService()->getItemById($id);
    }
}