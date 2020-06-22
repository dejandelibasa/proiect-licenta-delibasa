<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\forms\SeekerRegisterForm;

/* @var $this yii\web\View */

$this->title = $this->params['portal']->name;
?>
<div class="row">
	<div class="col-md-6">
		<h1 class="text-center">Seeker</h1>
		<?php 
			$seekerRegisterForm = ActiveForm::begin([
				'id' => 'seeker-register-form',
				'options' => ['class' => 'form-horizontal'],
			]);
			echo $seekerRegisterForm->field($seekerRegisterFormModel, 'email');
			echo $seekerRegisterForm->field($seekerRegisterFormModel, 'password')->passWordinput();
		?>
		<?php ActiveForm::end() ?>
	</div>
	<div class="col-md-6">
		<h1 class="text-center">Company</h1>
	</div>
</div>