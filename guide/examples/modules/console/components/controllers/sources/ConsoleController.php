<?php declare(strict_types=1);

namespace controllers\sources;

use app\common\components\base\Logger;
use app\common\components\base\services\items\ItemService;
use yii\console\Controller;

/**
 * < Console > Родительский класс для всех консольных контроллеров
 *
 * @package app\backend\components\controllers\sources
 *
 * @tag: #console #controller #sources
 */
abstract class ConsoleController extends Controller
{

    /** @var ItemService|string $classnameService */
    protected ItemService|string $classnameService;



    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();

        $this->setupService();
    }

    /**
     * @return bool
     */
    public function setupService(): bool
    {
        try
        {
            $this->service = new $this->classnameService();

            return true;

        } catch ( Exception $e ) {

            Logger::logCatch($e,__METHOD__, 'Catch! setupService()');
        }

        return false;
    }
}