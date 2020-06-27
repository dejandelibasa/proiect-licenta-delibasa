<?php

namespace app\models\forms;

class JobSearchForm extends \yii\base\Model
{
    public $title;
    public $location;


	public function rules()
	{
		return [
			[['title', 'location'], 'string']
		];
	}
}