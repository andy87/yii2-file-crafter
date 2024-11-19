<?php declare(strict_types=1);

namespace app\backend\tests\functional\items;

use Codeception\Actor;
use app\backend\tests\FunctionalTester;
use app\common\components\base\tests\unit\BaseWebControllerCest;

/**
 * < Backend > Тесты контроллера `PascalCaseController`
 *
 * @property  FunctionalTester $I
 *
 * @cli ./vendor/bin/codecept run app/backend/tests/functional/items/PascalCaseControllerCest
 *
 * @package app\backend\tests\functional\items
 *
 * @tag #backend #tests #functional #ContactCest
 */
class PascalCaseWebControllerCest extends BaseWebControllerCest
{
    /**
     * Тестирование экшена `index` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/backend/tests/functional/items/PascalCaseControllerCest:checkIndex
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @tag #backend #tests #functional #action #index
     */
    public function checkIndex( FunctionalTester|Actor $I ): void
    {
        //$I->see( $this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `create` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/backend/tests/functional/items/PascalCaseControllerCest:checkCreate
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @tag #backend #tests #functional #action #create
     */
    public function checkCreate( FunctionalTester|Actor $I ): void
    {
        //$I->see($this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `update` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/backend/tests/functional/items/PascalCaseControllerCest:checkUpdate
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @tag #backend #tests #functional #action #update
     */
    public function checkUpdate( FunctionalTester|Actor $I ): void
    {
        //$I->see($this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `view` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/backend/tests/functional/items/PascalCaseControllerCest:checkView
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @tag #backend #tests #functional #action #view
     */
    public function checkView( FunctionalTester|Actor $I ): void
    {
        //$I->see($this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `delete` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/backend/tests/functional/items/PascalCaseControllerCest:checkDelete
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @tag #backend #tests #functional #action #delete
     */
    public function checkDelete( FunctionalTester|Actor $I ): void
    {
        //$I->see($this->form::TITLE, 'h1');
    }
}
