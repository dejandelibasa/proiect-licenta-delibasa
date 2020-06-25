<?php

namespace app\models\forms;

class CompanyRegisterForm extends \yii\base\Model
{
	public $email;
	public $password;
	public $name;


	public function rules()
	{
		return [
			[['email', 'password', 'name'], 'required'],
			['email', 'email'],
			[['email'], 'unique'],
		];
	}
}