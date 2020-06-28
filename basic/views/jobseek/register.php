<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\forms\SeekerRegisterForm;
use app\models\forms\CompanyRegisterForm;

/* @var $this yii\web\View */

$this->title = $this->params['portal']->name;
?>
<div class="row">
	<?php $error = isset($error) ? $error : false; ?>
	<?php if($error): ?>
        <div class="alert alert-danger" role="alert">
            <p>
                <?= $error; ?>
            </p>
        </div>
    <?php endif; ?>
</div>
<div class="row">
	<div class="col-md-6">
		<h1 class="text-center"><?= Yii::t('app', 'Seeker') ?></h1>
		<?php 
			$seekerRegisterForm = ActiveForm::begin([
				'id' => 'seeker-register-form',
				'options' => ['class' => 'form-vertical'],
			]);
			echo $seekerRegisterForm->field($seekerRegisterFormModel, 'email');
			echo $seekerRegisterForm->field($seekerRegisterFormModel, 'password')->passWordinput();
			echo $seekerRegisterForm->field($seekerRegisterFormModel, 'first_name');
			echo $seekerRegisterForm->field($seekerRegisterFormModel, 'last_name');
			echo Html::submitButton(
				Yii::t('app', 'Register as Seeker'), 
				[
					'class' => 'btn form-group', 
					'style' => [
						'color' => $this->params['portal']->getSecondaryColorAsHex(),
						'background-color' => $this->params['portal']->getPrimaryColorAsHex(),
					],
					'value' => 'seeker', 
					'name' => 'register_submit'
			]);
		?>
		<?php ActiveForm::end() ?>
	</div>
	<div class="col-md-6">
		<h1 class="text-center"><?= Yii::t('app', 'Company') ?></h1>
		<?php 
			$companyRegisterForm = ActiveForm::begin([
				'id' => 'company-register-form',
				'options' => ['class' => 'form-vertical'],
			]);
			echo $companyRegisterForm->field($companyRegisterFormModel, 'email');
			echo $seekerRegisterForm->field($companyRegisterFormModel, 'password')->passWordinput();
			echo $seekerRegisterForm->field($companyRegisterFormModel, 'name');
			echo Html::submitButton(
				Yii::t('app', 'Register as Company'), 
				[
					'class' => 'btn btn-primary form-group',
					'style' => [
						'color' => $this->params['portal']->getSecondaryColorAsHex(),
						'background-color' => $this->params['portal']->getPrimaryColorAsHex(),
					],
					'value' => 'company',
					'name' => 'register_submit'
				]);
		?>
		<?php ActiveForm::end() ?>
	</div>
</div>