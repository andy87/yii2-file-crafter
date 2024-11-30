<?php declare(strict_types=1);

namespace app\common\components\base\tests\functional\items;

use Codeception\Actor;
use app\common\components\base\tests\functional\source\items\BaseUnitFunctionalTest;

/**
 * < Common > Base Controller Test
 *
 * @package app\common\components\base\tests\functional\items
 *
 * @cli ./vendor/bin/codecept run app/app\(frontend|backend)\components\base\tests\functional\items/BaseAcceptanceCest
 *
 * @tag: #abstract #base #test #controller
 */
abstract class BaseWebControllerCest extends BaseUnitFunctionalTest
{
    /**
     * Тестирование экшена `index`
     *
     * @cli ./vendor/bin/codecept run app\(frontend|backend)\components\base\tests\functional\items/BaseControllerCest:checkIndex
     *
     * @param Actor $I
     *
     * @return void
     */
    abstract public function checkIndex( Actor $I ): void;

    /**
     * Тестирование экшена `create`
     *
     * @cli ./vendor/bin/codecept run app\(frontend|backend)\components\base\tests\functional\items/BaseControllerCest:checkCreate
     *
     * @param  Actor $I
     *
     * @return void
     */
    abstract public function checkCreate( Actor $I ): void;

    /**
     * Тестирование экшена `update`
     *
     * @cli ./vendor/bin/codecept run app\(frontend|backend)\components\base\tests\functional\items/BaseControllerCest:checkUpdate
     *
     * @param  Actor $I
     *
     * @return void
     */
    abstract public function checkUpdate( Actor $I ): void;

    /**
     * Тестирование экшена `view`
     *
     * @cli ./vendor/bin/codecept run app\(frontend|backend)\components\base\tests\functional\items/BaseControllerCest:checkView
     *
     * @param  Actor $I
     *
     * @return void
     */
    abstract public function checkView( Actor $I ): void;

    /**
     * Тестирование экшена `delete`
     *
     * @cli ./vendor/bin/codecept run app\(frontend|backend)\components\base\tests\functional\items/BaseControllerCest:checkDelete
     *
     * @param  Actor $I
     *
     * @return void
     */
    abstract public function checkDelete( Actor $I ): void;
}