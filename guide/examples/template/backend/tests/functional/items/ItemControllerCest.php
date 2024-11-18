<?php declare(strict_types=1);


/**
 * < Backend > Тесты контроллера `ItemController`
 *
 * @package app\frontend\tests\functional
 *
 * @property \app\backend\tests\functional\controllers\items\FunctionalTester $I
 * @property \app\backend\tests\functional\controllers\items\ContactForm $form
 *
 * Fix not used:
 * - @see ContactCest::checkContact()
 * - @see ContactCest::checkContactSubmitNoData()
 * - @see ContactCest::checkContactSubmitNotCorrectEmail()
 * - @see ContactCest::checkContactSubmitCorrectData()
 *
 * @cli ./vendor/bin/codecept run app/backend/tests/functional/controllers/items/PascalCaseControllerCest
 *
 * @tag #backend #tests #functional #ContactCest
 */
class PascalCaseControllerCest
{
    /**
     * @param \app\backend\tests\functional\controllers\items\FunctionalTester $I
     *
     * @return void
     *
     * @see SiteController::actionContact()
     *
     * @tag #frontend #tests #functional #ContactCest #checkContact
     */
    public function _before(\app\backend\tests\functional\controllers\items\FunctionalTester $I): void
    {
        parent::_before($I);

        $route = \app\backend\tests\functional\controllers\items\SiteController::ENDPOINT . '/' . \app\backend\tests\functional\controllers\items\SiteController::ACTION_CONTACT;

        $I->amOnRoute($route);
    }

    /**
     * Check contact
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/ContactCest:checkContact
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/ContactCest.php#L16
     *
     * @param \app\backend\tests\functional\controllers\items\FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #ContactCest #checkContact
     */
    public function checkContact(\app\backend\tests\functional\controllers\items\FunctionalTester $I): void
    {
        $I->see( $this->form::TITLE, 'h1');
    }

    /**
     * Check contact submit no data
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/ContactCest:checkContactSubmitNoData
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/ContactCest.php#L21
     *
     * @param \app\backend\tests\functional\controllers\items\FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #ContactCest #checkContactSubmitNoData
     */
    public function checkContactSubmitNoData(\app\backend\tests\functional\controllers\items\FunctionalTester $I): void
    {
        $I->submitForm($this->formId, []);
        $I->see($this->form::TITLE, 'h1');
        $messages = [
            str_replace('{attribute}', $this->form->getAttributeLabel($this->form::ATTR_NAME), $this->form::RULE_REQUIRED_MESSAGE),
            str_replace('{attribute}', $this->form->getAttributeLabel($this->form::ATTR_EMAIL), $this->form::RULE_REQUIRED_MESSAGE),
            str_replace('{attribute}', $this->form->getAttributeLabel($this->form::ATTR_SUBJECT), $this->form::RULE_REQUIRED_MESSAGE),
            str_replace('{attribute}', $this->form->getAttributeLabel($this->form::ATTR_BODY), $this->form::RULE_REQUIRED_MESSAGE),
        ];
        foreach ($messages as $message) {
            $I->seeValidationError($message);
        }

        $I->seeValidationError($this->form::RULE_VERIFY_CODE_MESSAGE);
    }

    /**
     * Check contact submit not correct email
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/ContactCest:checkContactSubmitNotCorrectEmail
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/ContactCest.php#L32
     *
     * @param \app\backend\tests\functional\controllers\items\FunctionalTester $I
     *
     * @return void
     *
     * @tag #frontend #tests #functional #ContactCest #checkContactSubmitNotCorrectEmail
     */
    public function checkContactSubmitNotCorrectEmail(\app\backend\tests\functional\controllers\items\FunctionalTester $I): void
    {
        $I->submitForm($this->formId, [
            "$this->formName[". \app\backend\tests\functional\controllers\items\ContactForm::ATTR_NAME."]" => 'tester',
            "$this->formName[". \app\backend\tests\functional\controllers\items\ContactForm::ATTR_EMAIL."]" => 'tester.email',
            "$this->formName[". \app\backend\tests\functional\controllers\items\ContactForm::ATTR_SUBJECT."]" => 'test subject',
            "$this->formName[". \app\backend\tests\functional\controllers\items\ContactForm::ATTR_BODY."]" => 'test content',
            "$this->formName[". \app\backend\tests\functional\controllers\items\ContactForm::ATTR_VERIFY_CODE."]" => \app\backend\tests\functional\controllers\items\CaptchaAction::TEST_VALUE,
        ]);
        $I->seeValidationError('Email is not a valid email address.');
        $I->dontSeeValidationError('Name cannot be blank');
        $I->dontSeeValidationError('Subject cannot be blank');
        $I->dontSeeValidationError('Body cannot be blank');
        $I->dontSeeValidationError('The verification code is incorrect');
    }

    /**
     * Check contact submit correct data
     *
     * @cli ./vendor/bin/codecept run app/frontend/tests/functional/ContactCest:checkContactSubmitCorrectData
     *
     * @refer https://github.com/yiisoft/yii2-app-advanced/blob/master/frontend/tests/functional/ContactCest.php#L48
     *
     * @param \app\backend\tests\functional\controllers\items\FunctionalTester $I
     *
     * @return void
     *
     * @throws \app\backend\tests\functional\controllers\items\ModuleException
     *
     * @tag #frontend #tests #functional #ContactCest #checkContactSubmitCorrectData
     */
    public function checkContactSubmitCorrectData(\app\backend\tests\functional\controllers\items\FunctionalTester $I): void
    {
        $I->submitForm($this->formId, [
            "$this->formName[".$this->form::ATTR_NAME."]" => 'tester',
            "$this->formName[".$this->form::ATTR_EMAIL."]" => 'tester@example.com',
            "$this->formName[".$this->form::ATTR_SUBJECT."]" => 'test subject',
            "$this->formName[".$this->form::ATTR_BODY."]" => 'test content',
            "$this->formName[".$this->form::ATTR_VERIFY_CODE."]" => \app\backend\tests\functional\controllers\items\CaptchaAction::TEST_VALUE,
        ]);
        $I->seeEmailIsSent();
        $I->see($this->form::MESSAGE_SUCCESS);
    }
}
