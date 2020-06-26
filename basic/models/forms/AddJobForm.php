<?php

namespace app\models\forms;

class AddJobForm extends \yii\base\Model
{
    public $title;
    public $description;
    public $location;


	public function rules()
	{
		return [
			[['title', 'description'], 'required'],
		];
	}
}