<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\forms\AddJobForm;

/* @var $this yii\web\View */

$this->title = $this->params['portal']->name;
?>
<?php $error = isset($error) ? $error : false; ?>
<?php if($error): ?>
<div class="row">
    <div class="alert alert-danger" role="alert">
        <p>
            <?= $error; ?>
        </p>
    </div>
</div>
<?php endif; ?>
<div class="row">
    <div class="col">
        <h1 style="color: <?= $this->params['portal']->getSecondaryColorAsHex() ?>;">Edit Job</h1>
        <?php
            $editJobForm = ActiveForm::begin([
                'id' => 'edit-job-form',
                'options' => ['class' => 'form-vertical'],
            ]);
            echo $editJobForm->field($editJobFormModel, 'title');
            echo $editJobForm->field($editJobFormModel, 'description')->textArea(['maxLength' => 65535]);
            echo $editJobForm->field($editJobFormModel, 'location');
            echo Html::submitButton(
                Yii::t('app', 'Save changes to job'), 
                [
                    'class' => 'btn form-group', 
                    'style' => [
                        'color' => $this->params['portal']->getSecondaryColorAsHex(),
                        'background-color' => $this->params['portal']->getPrimaryColorAsHex(),
                    ],
                    'value' => 'edit_job', 
                    'name' => 'edit_job_submit'
                ]);
        ?>
        <?php ActiveForm::end() ?>
    </div>
</div>