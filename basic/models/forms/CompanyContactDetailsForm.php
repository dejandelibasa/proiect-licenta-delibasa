<?php

namespace app\models\forms;

class CompanyContactDetailsForm extends \yii\base\Model
{
    public $email;
    public $telephone_number;
    public $contact_person_name;
    public $ceo_name;


	public function rules()
	{
		return [
			[['email', 'telephone_number'], 'required'],
			[['telephone_number'], 'integer'],
			[['email'], 'email']
		];
	}
}