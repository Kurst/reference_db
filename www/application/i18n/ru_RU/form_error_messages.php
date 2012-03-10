<?php defined('SYSPATH') or die('No direct access allowed.');
 
$lang = array
(
'name' => Array
    (
        'required' => 'Поле нужно заполнить',
        'alpha' => 'Можно использовать только буквы',
        'length' => 'The name must be between three and twenty letters.',
        'default' => 'Недопустимое значение',
    ),
'family' => Array
    (
        'required' => 'Поле нужно заполнить',
        'alpha' => 'Можно использовать только буквы',
        'length' => 'The name must be between three and twenty letters.',
        'default' => 'Недопустимое значение',
    ),
'patronymic' => Array
    (
        'required' => 'Поле нужно заполнить',
        'alpha' => 'Можно использовать только буквы',
        'length' => 'The name must be between three and twenty letters.',
        'default' => 'Недопустимое значение',
    ),
'date' => Array
    (
        'required' => 'Поле нужно заполнить',
        'alpha' => 'Можно использовать только буквы',
        'length' => 'The name must be between three and twenty letters.',
        'default' => 'Недопустимое значение',
        'bad_format' => 'Неправильный формат'
    ),
'town' => Array
    (
        'required' => 'Поле нужно заполнить',
        'alpha' => 'Можно использовать только буквы',
        'length' => 'The name must be between three and twenty letters.',
        'default' => 'Недопустимое значение',
    ),
'email' => Array
    (
        'required' => 'Поле нужно заполнить',
        'alpha' => 'Можно использовать только буквы',
        'length' => 'The name must be between three and twenty letters.',
        'default' => 'Недопустимое значение',
        'email' => 'Неверный адрес',
        'exist_check' => 'Такой пользователь уже существует'
    ),
'phone' => Array
    (
        'required' => 'Поле нужно заполнить',
        'alpha' => 'Можно использовать только буквы',
        'length' => 'The name must be between three and twenty letters.',
        'default' => 'Недопустимое значение',
        'phone' => 'Неправильный номер',
    ),
'site' => Array
    (
        'required' => 'Поле нужно заполнить',
        'alpha' => 'Можно использовать только буквы',
        'length' => 'The name must be between three and twenty letters.',
        'default' => 'Недопустимое значение',
    ),
'desc' => Array
    (
        'required' => 'Поле нужно заполнить',
        'alpha' => 'Можно использовать только буквы',
        'length' => 'The name must be between three and twenty letters.',
        'default' => 'Недопустимое значение',
    ),
'number' => Array
    (
        'required' => 'Поле нужно заполнить',
        'numeric' => 'Only numbers are allowed.',
        'length' => 'The number must be between three and five numerals.',
        'default' => 'Недопустимое значение',
    ),
'code' => Array
    (
        'numeric' => 'Only numbers are allowed.',
        'length' => 'The code must be exactly three numerals.',
        'default' => 'Недопустимое значение',
    ),
'isbn' => Array
    (
    	'required' => 'Поле нужно заполнить',
        'numeric' => 'Только цифры',
        'length' => 'В коде должно быть 13 цифр',
        'default' => 'Недопустимое значение',
        'bad_format' => 'Неправильный формат'
    ),
    
'title' => Array
    (
        'required' => 'Поле нужно заполнить',
        'default' => 'Недопустимое значение',
    ),
'issue' => Array
    (
        'required' => 'Поле нужно заполнить',
        'default' => 'Недопустимое значение',
    ),
'password' => Array
    (
        'required' => 'Введите пароль',
        'pwd_check' => 'Пароль неверный',
        'default' => 'Поле нужно заполнить',
    ),
'circulation' => Array
	(
		 'required' => 'Поле нужно заполнить',
		 'digit' => 'положительное целое число',
        'default' => 'Недопустимое значение',
	),
 'author_1' => Array
        (
         'default' => 'Поле нужно заполнить'
        ),
 'type' => Array
        (
         'not_selected' => 'Тип не выбран'
        ),
 'confirm' => Array
        (
         'pwd_check' => 'Пароль не совпадает',
         'default' => 'Подтвердите пароль'
        )
);