<?php

//$mailTo = 'petun911@gmail.com';
$mailTo = 'petun@Air-Petr.Dlink';
$siteName = 'example.com';

$config = array(
	'feedbackForm' => array(
		'successMessage' => 'ОК',
		'fields' => array(
			'name' => 'Ваше имя',
			'telephone' => 'Ваш телефон',
			'email' => 'Email',
			'select-box' => 'select-box',
			'check-test' => 'test check',
			'regexText' => 'Regex Text',

		),
		'rules' => array(
			array('name', 'required'),
			array('telephone', 'required'),
			array('email', 'email', 'allowEmpty' => false),
			array('regexText', 'regex', 'rule' => '/\d+/', 'errorMessage' => 'В поле %s должны быть только числа'),
		),
		'actions' => array(
			array(
				'mail', 'subject' => 'Новое письмо с сайта',
				'from' => 'no-reply@' . $siteName,
				'fromName' => 'Администратор',
				'to' => $mailTo
			),
			/*array(
				'redirect',
			),*/
			array(
				'modxResource',
				'coreCmsPath' => '/Users/petun/Sites/modx/core/',
				'fields' => array(
					'pagetitle' => array('eval' => '$this->_form->fieldValue("name")'),
					'parent' => array('value' => '0'),
					'template' => array('value' => '1'),
					'published' => array('value' => '1'),
					'description' => array('value' => 'sample description'),
					'introtext' => array('eval' => '$this->_form->fieldValue("telephone") . $this->_form->fieldValue("email")'),
				),
				'tv' => array(
					'date' => array('value' => '2013-01-01 12:12'),
					'typeId' => array('value' => '3')
				)
			),
			array(
				'netcat',
				'fields' => array(
					/*
					 * '
					 * Subdivision_ID' => $subId,
            'Sub_Class_ID' => $ccId,
            'User_ID' => 1,
            'Checked' => 1,
					Created
					 */
				)
			)
		)
	),

	'callbackForm' => array(
		'fields' => array(
			'name' => 'Ваше имя',
			'telephone' => 'Ваш телефон',
			'comment' => 'Комментарий / вопрос',
		),
		'rules' => array(
			array('name', 'required'),
			array('telephone', 'regex', 'rule' => '/^[\d\s\+\-\(\)]+$/', 'errorMessage'=> 'Введите корректный номер телефона' ),
			array('comment', 'required'),
		),
		'actions' => array(
			array(
				'mail',
				'subject' => 'Новое письмо с сайта',
				'from' => 'no-reply@' . $siteName,
				'fromName' => 'Администратор',
			),
		)
	),

	'feedbackFormSimple' => array(
		'fields' => array(
			'name' => 'Ваще имя',
			'telephone' => 'Ваш телефон',
			'email' => 'Email',
		),
		'rules' => array(
			array('name', 'required'),
			array('telephone', 'required'),
			array('email', 'email'),
		),
		'actions' => array(
			array('counter'), // put this action at the top of the actions
			array(
				'mail', 'subject' => 'Новое письмо с сайта (для администратора)',
				'template' => 'default.tpl', // можно не указывать. Этот шаблон по умолчанию
				'from' => 'no-reply@' . $siteName,
				'fromName' => 'Администратор',
				'to' => $mailTo
			),
			array(
				'userMail', 'subject' => 'Ваш заказ успешно обработан',
				'template' => 'default.tpl', // можно не указывать. Этот шаблон по умолчанию
				'from' => 'no-reply@' . $siteName,
				'fromName' => 'Администратор',
				'to' => array('eval'=> '$this->_form->fieldValue("email")'),
			),
		)
	),
);