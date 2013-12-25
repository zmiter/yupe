<?php
use \WebGuy;

class UserLoginCest
{
    public function testLoginPage(WebGuy $I, $scenario)
    {
        $I->amOnPage(LoginPage::$URL);
        $I->wantTo('Check login form elements...');
        $I->seeInTitle(\CommonPage::LOGIN_LABEL);
        $I->seeLink('Забыли пароль?');
        $I->see(\CommonPage::LOGIN_LABEL);
        $I->see('Запомнить меня');
        $I->dontSeeCheckboxIsChecked(LoginPage::$rememberMeField);
        $I->seeLink('Регистрация');
        $I->seeInField(LoginPage::$emailField, '');
        $I->seeInField(LoginPage::$passwordField, '');

        $I->amOnPage(LoginPage::$URL);
        $I->wantTo('Check form with wrong data format...');
        $I->fillField(LoginPage::$emailField, 'test');
        $I->fillField(LoginPage::$passwordField, 'testpass');
        $I->click(\CommonPage::LOGIN_LABEL, \CommonPage::BTN_PRIMARY_CSS_CLASS);
        $I->see('Email не является правильным E-Mail адресом.', \CommonPage::ERROR_CSS_CLASS);

        $I->amOnPage(LoginPage::$URL);
        $I->wantTo('Check form with wrong data...');
        $I->fillField(LoginPage::$emailField, 'test@test.ru');
        $I->fillField(LoginPage::$passwordField, 'testpass');
        $I->click(\CommonPage::LOGIN_LABEL, \CommonPage::BTN_PRIMARY_CSS_CLASS);
        $I->see('Email или пароль введены неверно!', \CommonPage::ERROR_CSS_CLASS);

        $I = new WebGuy\UserSteps($scenario);
        $I->login('yupe@yupe.local','testpassword');
    }
}