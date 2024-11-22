<?php declare(strict_types=1);

namespace app\common\components\base\tests\unit;

use Codeception\Actor;

/**
 * < Common > Base Controller Test
 *
 * @package app\common\components\base\tests\unit
 *
 * @cli ./vendor/bin/codecept run app/common/components/base/tests/acceptance/BaseAcceptanceCest
 *
 * @tag: #base #test #controller
 */
abstract class BaseWebControllerCest
{
    /**
     * Тестирование экшена `index`
     *
     * @cli ./vendor/bin/codecept run app/(frontend|backend)/tests/functional/BaseControllerCest:checkIndex
     *
     * @param Actor $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #action #index
     */
    abstract public function checkIndex( Actor $I ): void;

    /**
     * Тестирование экшена `create`
     *
     * @cli ./vendor/bin/codecept run app/(frontend|backend)/tests/functional/BaseControllerCest:checkCreate
     *
     * @param  Actor $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #action #create
     */
    abstract public function checkCreate( Actor $I ): void;

    /**
     * Тестирование экшена `update`
     *
     * @cli ./vendor/bin/codecept run app/(frontend|backend)/tests/functional/BaseControllerCest:checkUpdate
     *
     * @param  Actor $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #action #update
     */
    abstract public function checkUpdate( Actor $I ): void;

    /**
     * Тестирование экшена `view`
     *
     * @cli ./vendor/bin/codecept run app/(frontend|backend)/tests/functional/BaseControllerCest:checkView
     *
     * @param  Actor $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #action #view
     */
    abstract public function checkView( Actor $I ): void;

    /**
     * Тестирование экшена `delete`
     *
     * @cli ./vendor/bin/codecept run app/(frontend|backend)/tests/functional/BaseControllerCest:checkDelete
     *
     * @param  Actor $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #action #delete
     */
    abstract public function checkDelete( Actor $I ): void;
}