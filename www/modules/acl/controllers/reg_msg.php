<?php
defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Reg_msg controller
 *
 * Special controller for custom messages in registration module.
 * 
 * @copyright   Copyright (C) 2010 Ilya Semerhanov
 * @author      Ilya Semerhanov
 * @version     1.2
 * @package     Acl_Core
 */

class Reg_msg_Controller extends Template_Controller
{
	const ALLOW_PRODUCTION = TRUE;

	public $template = 'reg_msg_view';
	public $acl;

	public function __construct()
	{
		parent::__construct();
                $this->template->title        = "";
                $this->template->sub_title    = "";
                $this->template->msg          = "";

	}

        public function index()
        {
                die('Error');
        }


        public function failure()
        {
              $this->template->title        = "Ошибка";
              $this->template->sub_title    = "Ошибка";
              $this->template->msg          = "Произошла ошибка";
              
                
        }

        public function success()
        {
              $this->template->title        = "Регистрация прошла успешно";
              $this->template->sub_title    = "Регистрация прошла успешно";
              $this->template->msg          = "Регистрация успешно пройдена, ваш аккаунт активирован. Добро пожаловать в систему!";
              $this->template->link_text    = "Войти";
              $this->template->link         = "login";

        }

        public function activate()
        {
              $this->template->title        = "Подтвержение";
              $this->template->sub_title    = "Подтверждение";
              $this->template->msg          = "Для продолжения регистрации необходимо подтвердить указанный вами адрес электронной почты. Вам отправлено письмо.";
            

        }

        public function admin()
        {
              $this->template->title        = "Ошибка";
              $this->template->sub_title    = "Ошибка";
              $this->template->msg          = "Произошел сбой, обратитесь к администратору системы по адресу: admin@reference_db.com";


        }

        public function timeout()
        {
              $this->template->title        = "Ошибка";
              $this->template->sub_title    = "Ошибка";
              $this->template->msg          = "Время сессии истекло";
              $this->template->link_text    = "Войти";
              $this->template->link         = "login";


        }

        public function no_user()
        {
              $this->template->title        = "Ошибка";
              $this->template->sub_title    = "Ошибка";
              $this->template->msg          = "Такого адреса не найдено";


        }

        public function restore()
        {
              $this->template->title        = "Восстановление пароля";
              $this->template->sub_title    = "Восстановление пароля";
              $this->template->msg          = "На указанный вами адрес было отправлено письмо с инструкцией для восстановления пароля";


        }

        public function not_similar()
        {
              $this->template->title        = "Восстановление пароля";
              $this->template->sub_title    = "Восстановление пароля";
              $this->template->msg          = "Вы ошиблись при повторе пароля";


        }

        public function restore_success()
        {
              $this->template->title        = "Восстановление пароля";
              $this->template->sub_title    = "Восстановление пароля";
              $this->template->msg          = "Вы успешно восстановили пароль";


        }

}
?>
