<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

use app\models\Job;
use app\models\Company;

/* @var $this yii\web\View */

$this->title = $this->params['portal']->name;
?>
<h1>Your job application</h1>
<?= GridView::widget([
        'dataProvider' => $jobApplications,
        'columns' => [
            [
                'label' => 'Job Title',
                'format' => 'raw',
                'value' => function($model) {
                    return Job::findOne($model->job_id)->title;
                },
            ],
            [
                'label' => 'Company',
                'format' => 'raw',
                'value' => function($model) {
                    return Company::findOne(Job::findOne($model->job_id)->company_id)->name;
                }
            ],
            'date'
        ],
    ])?>