<?php declare(strict_types=1);

namespace app\frontend\tests\functional\items;

use Codeception\Actor;
use app\common\components\Action;
use app\frontend\tests\FunctionalTester;
use app\frontend\controllers\PascalCaseController;
use app\common\components\base\tests\unit\BaseWebControllerCest;

/**
 * < Frontend > Тесты контроллера `PascalCaseController`
 *
 * @property  FunctionalTester $I
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/functional/items/PascalCaseControllerCest
 *
 * @package app\frontend\tests\functional\items
 *
 * @tag #frontend #tests #functional #ContactCest
 */
class PascalCaseWebControllerCest extends BaseWebControllerCest
{
    /** @var string Для контроллера `UserGroupController` будет `user-group` */
    public const ENDPOINT = PascalCaseController::ENDPOINT;

    /**
     * Тестирование экшена `index` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/items/PascalCaseControllerCest:checkIndex
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #action #index
     */
    public function checkIndex( FunctionalTester|Actor $I ): void
    {
        $I->amOnRoute(self::ENDPOINT . '/' . Action::INDEX);

        //$I->see( $this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `create` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/items/PascalCaseControllerCest:checkCreate
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #action #create
     */
    public function checkCreate( FunctionalTester|Actor $I ): void
    {
        $I->amOnRoute(self::ENDPOINT . '/' . Action::CREATE);

        //$I->see($this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `update` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/items/PascalCaseControllerCest:checkUpdate
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #action #update
     */
    public function checkUpdate( FunctionalTester|Actor $I ): void
    {
        $I->amOnRoute(self::ENDPOINT . '/' . Action::UPDATE);

        //$I->see($this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `view` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/items/PascalCaseControllerCest:checkView
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #action #view
     */
    public function checkView( FunctionalTester|Actor $I ): void
    {
        $I->amOnRoute(self::ENDPOINT . '/' . Action::VIEW);

        //$I->see($this->form::TITLE, 'h1');
    }

    /**
     * Тестирование экшена `delete` контроллера `PascalCaseController`
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/items/PascalCaseControllerCest:checkDelete
     *
     * @param  FunctionalTester|Actor $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #action #delete
     */
    public function checkDelete( FunctionalTester|Actor $I ): void
    {
        $I->amOnRoute(self::ENDPOINT . '/' . Action::DELETE);

        //$I->see($this->form::TITLE, 'h1');

        $I->canSeeResponseCodeIs(302);
    }
}
