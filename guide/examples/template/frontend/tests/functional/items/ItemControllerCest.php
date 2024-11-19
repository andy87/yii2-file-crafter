<?php declare(strict_types=1);

namespace app\frontend\tests\functional\items;

use app\frontend\tests\FunctionalTester;

/**
 * < Frontend > Тесты контроллера `PascalCaseController`
 *
 * @property  FunctionalTester $I
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/functional/PascalCaseControllerCest
 *
 * @package app\frontend\tests\functional\items
 *
 * @tag #frontend #tests #functional #ContactCest
 */
class PascalCaseControllerCest
{
    /**
     * Тестирование экшена `index` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/PascalCaseControllerCest:checkIndex
     *
     * @param  FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #action #index
     */
    public function checkIndex( FunctionalTester $I ): void
    {
        //$I->see( $this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `create` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/PascalCaseControllerCest:checkCreate
     *
     * @param  FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #action #create
     */
    public function checkCreate( FunctionalTester $I ): void
    {
        //$I->see($this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `update` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/PascalCaseControllerCest:checkUpdate
     *
     * @param  FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #action #update
     */
    public function checkUpdate( FunctionalTester $I ): void
    {
        //$I->see($this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `view` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/PascalCaseControllerCest:checkView
     *
     * @param  FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #action #view
     */
    public function checkView( FunctionalTester $I ): void
    {
        //$I->see($this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `delete` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/PascalCaseControllerCest:checkDelete
     *
     * @param  FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #action #delete
     */
    public function checkDelete( FunctionalTester $I ): void
    {
        //$I->see($this->form::TITLE, 'h1');
    }
}
