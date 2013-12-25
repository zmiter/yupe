<?php
/**
 * Экшн, отвечающий за процедуру восстановления пароля пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.6
 * @link     http://yupe.ru
 *
 **/

use yupe\components\WebModule;

class RecoveryPasswordAction extends CAction
{
    /**
     * Стартуем экшен сброса пароля
     * @param string $token - токен-сброса пароля
     * @throws CHttpException
     */
    public function run($token)
    {
        if (Yii::app()->user->isAuthenticated()) {
            $this->controller->redirect(Yii::app()->user->returnUrl);
        }

        $module = Yii::app()->getModule('user');

        // Если запрещено восстановление - печалька ;)
        if ($module->recoveryDisabled) {
            throw new CHttpException(404, Yii::t('UserModule.user', 'requested page was not found!'));
        }

        // Если включено автоматическое восстановление пароля:
        if ((int)$module->autoRecoveryPassword === WebModule::CHOICE_YES) {

            if (Yii::app()->userManager->activatePassword($token)) {

                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('UserModule.user', 'New password was sent to your email')
                );

                $this->controller->redirect(array('/user/account/login'));

            } else {

                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('UserModule.user', 'Error when changing password!')
                );

                $this->controller->redirect(array('/user/account/recovery'));
            }
        }

        // Форма смены пароля:
        $changePasswordForm = new ChangePasswordForm;

        // Получаем данные POST если таковые имеются:
        if (($data = Yii::app()->getRequest()->getPost('ChangePasswordForm')) !== null) {

            // Заполняем поля формы POST-данными:
            $changePasswordForm->setAttributes($data);

            // Проводим валидацию формы:
            if ($changePasswordForm->validate() && Yii::app()->userManager->activatePassword($token, $changePasswordForm->password)) {

                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('UserModule.user', 'Password recover successfully')
                );

                $this->controller->redirect(array('/user/account/login'));

            } else {

                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('UserModule.user', 'Error when changing password!')
                );

                $this->controller->redirect(array('/user/account/recovery'));
            }
        }

        // Отрисовываем форму:
        $this->controller->render('changePassword', array('model' => $changePasswordForm));
    }
}