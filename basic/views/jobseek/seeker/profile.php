<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

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
<?php $seekerUploadCvForm = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <?= $seekerUploadCvForm->field($seekerUploadCVFormModel, 'CV')->fileInput() ?>
    
<?php ActiveForm::end() ?>