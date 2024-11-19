<?php declare(strict_types=1);

namespace app\backend\tests\functional\items;

use app\backend\tests\FunctionalTester;

/**
 * < Backend > Тесты контроллера `PascalCaseController`
 *
 * @property  FunctionalTester $I
 *
 * @cli ./vendor/bin/codecept run app/backend/tests/functional/PascalCaseControllerCest
 *
 * @package app\backend\tests\functional\items
 *
 * @tag #backend #tests #functional #ContactCest
 */
class PascalCaseControllerCest
{
    /**
     * Тестирование экшена `index` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/backend/tests/functional/PascalCaseControllerCest:checkIndex
     *
     * @param  FunctionalTester $I
     *
     * @return void
     *
     * @tag #backend #tests #functional #action #index
     */
    public function checkIndex( FunctionalTester $I ): void
    {
        //$I->see( $this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `create` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/backend/tests/functional/PascalCaseControllerCest:checkCreate
     *
     * @param  FunctionalTester $I
     *
     * @return void
     *
     * @tag #backend #tests #functional #action #create
     */
    public function checkCreate( FunctionalTester $I ): void
    {
        //$I->see($this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `update` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/backend/tests/functional/PascalCaseControllerCest:checkUpdate
     *
     * @param  FunctionalTester $I
     *
     * @return void
     *
     * @tag #backend #tests #functional #action #update
     */
    public function checkUpdate( FunctionalTester $I ): void
    {
        //$I->see($this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `view` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/backend/tests/functional/PascalCaseControllerCest:checkView
     *
     * @param  FunctionalTester $I
     *
     * @return void
     *
     * @tag #backend #tests #functional #action #view
     */
    public function checkView( FunctionalTester $I ): void
    {
        //$I->see($this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `delete` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/backend/tests/functional/PascalCaseControllerCest:checkDelete
     *
     * @param  FunctionalTester $I
     *
     * @return void
     *
     * @tag #backend #tests #functional #action #delete
     */
    public function checkDelete( FunctionalTester $I ): void
    {
        //$I->see($this->form::TITLE, 'h1');
    }
}
