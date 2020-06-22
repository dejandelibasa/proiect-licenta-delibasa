<?php

namespace app\models\forms;

class SeekerRegisterForm extends \yii\base\Model
{
	public $email;
	public $password;
	public $firstName;
	public $lastName;


	public function rules()
	{
		return [
			[['email', 'password', 'firstName'], 'required'],
			['email', 'email']
		];
	}
}