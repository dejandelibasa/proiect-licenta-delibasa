<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Job;
use app\models\Company;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */

$this->title = $this->params['portal']->name;
?>
<div class="text-center">
    <?php 
        $jobSearchForm = ActiveForm::begin([
            'id' => 'job-search-form',
            'type' => ActiveForm::TYPE_INLINE,
            'fieldConfig' => ['options' => ['class' => 'form-group mr-2']],
        ]);
    ?>
    <?= $jobSearchForm->field($jobSearchFormModel, 'title') ?>
    <?= $jobSearchForm->field($jobSearchFormModel, 'location') ?>
    <?= Html::submitButton(Yii::t('app', 'Search jobs'), [
        'class' => 'btn', 
        'style' => 'background-color: ' . Yii::$app->view->params['portal']->getPrimaryColorAsHex() . '; color:' . Yii::$app->view->params['portal']->getSecondaryColorAsHex() . ';',
        'value' => 'job_search', 
        'name' => 'index_route',
        ]) ?>
    <?php ActiveForm::end(); ?>
</div>
<?= GridView::widget([
    'dataProvider' => $jobsDataProvider,
    'columns' => [
        [
            'label' => 'title',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->title, ['job/view', 'portal_id' => Yii::$app->view->params['portal']->id, 'job_id' => $model->id]);
            },
         ],
        'location',
        'created_at'
    ],
    'summary' => "{end}/{totalCount} jobs",
    'showHeader' => false,
]) ?>