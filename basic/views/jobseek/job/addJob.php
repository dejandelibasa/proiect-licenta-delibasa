<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\forms\AddJobForm;

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
    <div class="col">
        <h1 style="color: <?= $this->params['portal']->getSecondaryColorAsHex() ?>;">Add Job</h1>
        <?php
            $addJobForm = ActiveForm::begin([
                'id' => 'add-job-form',
                'options' => ['class' => 'form-vertical'],
            ]);
            echo $addJobForm->field($addJobFormModel, 'title');
            echo $addJobForm->field($addJobFormModel, 'description')->textArea(['maxLength' => 65535]);
            echo $addJobForm->field($addJobFormModel, 'location');
            echo Html::submitButton(
                                    Yii::t('app', 'Save job'), 
                                    [
                                        'class' => 'btn form-group', 
                                        'style' => [
                                            'color' => $this->params['portal']->getSecondaryColorAsHex(),
                                            'background-color' => $this->params['portal']->getPrimaryColorAsHex(),
                                        ],
                                        'value' => 'add_job', 
                                        'name' => 'add_job_submit'
                                    ]
            );
        ?>
        <?php ActiveForm::end() ?>
    </div>
</div>