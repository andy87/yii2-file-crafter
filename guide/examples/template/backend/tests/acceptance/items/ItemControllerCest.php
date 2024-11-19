<?php declare(strict_types=1);

namespace app\backend\tests\acceptance\items;

use Codeception\Actor;
use app\common\components\base\tests\acceptance\BaseWebAcceptanceCest;

/**
 * < Backend > PascalCaseControllerCest Acceptance Test
 *
 * @property Actor $I
 *
 * @cli ./vendor/bin/codecept run app/backend/tests/acceptance/items/ItemControllerCest
 *
 * @package app\backend\tests\acceptance\items
 *
 * @tag #backend #test #acceptance #{{snake_case}}
 */
class PascalCaseControllerCest extends BaseWebAcceptanceCest
{
    /**
     * @cli ./vendor/bin/codecept run app/backend/tests/acceptance/BaseAcceptanceCest:checkIndex
     *
     * @param Actor $I
     *
     * @return void
     */
    public function checkIndex(Actor $I): void
    {
        //$I->amOnRoute(Url::toRoute('/site/index'));
        //$I->see('My Application');

        //$I->seeLink('About');
        //$I->click('About');
        //$I->wait(2); // wait for page to be opened

        //$I->see('This is the About page.');
    }

    /**
     * @cli ./vendor/bin/codecept run app/backend/tests/acceptance/BaseAcceptanceCest:checkCreate
     *
     * @return void
     */
    public function checkCreate(): void
    {
        //$I->amOnRoute(Url::toRoute('/site/index'));
        //$I->see('My Application');

        //$I->seeLink('About');
        //$I->click('About');
        //$I->wait(2); // wait for page to be opened

        //$I->see('This is the About page.');
    }

    /**
     * @cli ./vendor/bin/codecept run app/backend/tests/acceptance/BaseAcceptanceCest:checkUpdate
     *
     * @return void
     */
    public function checkUpdate(): void
    {
        //$I->amOnRoute(Url::toRoute('/site/index'));
        //$I->see('My Application');

        //$I->seeLink('About');
        //$I->click('About');
        //$I->wait(2); // wait for page to be opened

        //$I->see('This is the About page.');
    }

    /**
     * @cli ./vendor/bin/codecept run app/backend/tests/acceptance/BaseAcceptanceCest:checkView
     *
     * @return void
     */
    public function checkView(): void
    {
        //$I->amOnRoute(Url::toRoute('/site/index'));
        //$I->see('My Application');

        //$I->seeLink('About');
        //$I->click('About');
        //$I->wait(2); // wait for page to be opened

        //$I->see('This is the About page.');
    }

    /**
     * @cli ./vendor/bin/codecept run app/backend/tests/acceptance/BaseAcceptanceCest:checkDelete
     *
     * @return void
     */
    public function checkDelete(): void
    {
        //$I->amOnRoute(Url::toRoute('/site/index'));
        //$I->see('My Application');

        //$I->seeLink('About');
        //$I->click('About');
        //$I->wait(2); // wait for page to be opened

        //$I->see('This is the About page.');
    }
}