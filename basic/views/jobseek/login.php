<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\forms\UserLogin;
/* @var $this yii\web\View */

$this->title = $this->params['portal']->name;
?>
<div class="row">
	<?php if($error): ?>
        <div class="alert alert-danger" role="alert">
            <p>
                <?= $error; ?>
            </p>
        </div>
    <?php endif; ?>
</div>
<div class="row">
        <div class="col">
            <h1><?= Yii::t('app', 'Login') ?></h1>
            <?php
                $userLoginForm = ActiveForm::begin([
                    'id' => 'user-login-form',
                    'options' => ['class' => 'form-vertical'],
                ]);
                echo $userLoginForm->field($userLoginFormModel, 'email');
                echo $userLoginForm->field($userLoginFormModel, 'password')->passwordInput();
                echo Html::submitButton(Yii::t('app', 'Login button'), ['class' => 'btn btn-primary form-group', 'value' => 'user_login', 'name' => 'user_login_submit']);
            ?>
            <?php ActiveForm::end() ?>
        </div>
</div>