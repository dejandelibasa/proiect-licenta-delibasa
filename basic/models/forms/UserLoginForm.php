<?php

namespace app\models\forms;

class UserLoginForm extends \yii\base\Model
{
	public $email;
	public $password;


	public function rules()
	{
		return [
			[['email', 'password'], 'required'],
			['email', 'email']
		];
	}
}