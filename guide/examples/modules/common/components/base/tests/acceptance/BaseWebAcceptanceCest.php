<?php declare(strict_types=1);

namespace app\common\components\base\tests\acceptance;

use Codeception\Actor;

/**
 * < Common > Base Acceptance Test
 *
 * @property Actor $I
 *
 * @cli ./vendor/bin/codecept run app/(frontend|backend)/tests/acceptance/HomeCest
 *
 * @package app\common\components\base\tests\acceptance
 *
 * @tag: #base #test #acceptance
 */
abstract class BaseWebAcceptanceCest
{
    /**
     * @cli ./vendor/bin/codecept run app/(frontend|backend)/tests/acceptance/BaseAcceptanceCest:checkIndex
     *
     * @param Actor $I
     *
     * @return void
     */
    abstract public function checkIndex(Actor $I): void;

    /**
     * @cli ./vendor/bin/codecept run app/(frontend|backend)/tests/acceptance/BaseAcceptanceCest:checkView
     *
     * @return void
     */
    abstract public function checkView(): void;
}