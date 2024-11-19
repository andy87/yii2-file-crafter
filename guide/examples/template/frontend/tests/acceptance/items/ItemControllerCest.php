<?php declare(strict_types=1);

namespace app\frontend\tests\acceptance\items;

use Codeception\Actor;
use app\common\components\base\tests\acceptance\BaseWebAcceptanceCest;

/**
 * < Frontend > PascalCaseControllerCest Acceptance Test
 *
 * @property Actor $I
 *
 * @cli ./vendor/bin/codecept run app/frontend/tests/acceptance/items/ItemControllerCest
 *
 * @package app\frontend\tests\acceptance\items
 *
 * @tag #frontend #test #acceptance #{{snake_case}}
 */
class PascalCaseControllerCest extends BaseWebAcceptanceCest
{
    /**
     * @cli ./vendor/bin/codecept run app/frontend/tests/acceptance/BaseAcceptanceCest:checkIndex
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
     * @cli ./vendor/bin/codecept run app/frontend/tests/acceptance/BaseAcceptanceCest:checkView
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
}