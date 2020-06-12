<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Portal */

$this->title = Yii::t('app', 'Create Portal');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Portals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
