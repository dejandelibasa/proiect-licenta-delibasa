<?php

namespace app\models\forms;

class SeekerRegisterForm extends \yii\base\Model
{
	public $email;
	public $password;
	public $first_name;
	public $last_name;


	public function rules()
	{
		return [
			[['email', 'password', 'first_name'], 'required'],
			['email', 'email'],
			[['email'], 'unique'],
		];
	}
}