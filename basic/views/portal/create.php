<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput;

/* @var $this yii\web\View */
/* @var $model app\models\Portal */

$this->title = Yii::t('app', 'Create Portal');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Portals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php 
			$portalForm = ActiveForm::begin([
				'id' => 'portal-create-form',
				'options' => ['class' => 'form-horizontal'],
            ]);
    ?>
    <?= $portalForm->field($model, 'name'); ?>
    <?= ColorInput::widget([
        'model' => $model,
        'attribute' => 'primary_color'
    ]); ?>
    <?= ColorInput::widget([
        'model' => $model,
        'attribute' => 'secondary_color'
    ]); ?>
    <?= Html::submitButton(Yii::t('app', 'Create portal'), ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>

</div>
