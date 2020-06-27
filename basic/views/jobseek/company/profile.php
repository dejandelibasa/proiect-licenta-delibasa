<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

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
<p>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#top-5-jobs-collapse" aria-expanded="false" aria-controls="top-5-jobs-collapse">
    <?= Yii::t('app', 'Click to view the last 5 jobs you have added.') ?>
  </button>
</p>
<div class="collapse" id="top-5-jobs-collapse">
  <div class="card card-body">
  <?= GridView::widget([
        'dataProvider' => $last_5_jobs,
        'columns' => [
            [
                'label' => 'title',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->title, ['job/view', 'portal_id' => Yii::$app->view->params['portal']->id, 'job_id' => $model->id]);
                },
             ],
            'location',
            'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{edit} {delete}',
                'buttons' => [
                    'edit' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 
                                    Url::to(['job/edit', 'portal_id' => Yii::$app->view->params['portal']->id, 'job_id' => $model->id]), 
                                    ['title' => Yii::t('app', 'Edit job')]
                        );
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                    Url::to(['job/delete', 'portal_id' => Yii::$app->view->params['portal']->id, 'job_id' => $model->id]),
                                    ['title' => Yii::t('app', 'Delete job')]
                        );
                    }
                ]
            ],
        ],
        'summary' => "{totalCount} jobs",
    ]); ?>
  </div>
</div>