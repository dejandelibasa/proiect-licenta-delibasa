<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

use app\models\Job;
use app\models\Seeker;
use app\models\User;

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
                'label' => 'User',
                'format' => 'raw',
                'value' => function($model) {
                    return 
                        Seeker::find()->innerJoin('User', 'User.id = ' . $model->user_id)->one()->first_name .
                        " " .
                        Seeker::find()->innerJoin('User', 'User.id = ' . $model->user_id)->one()->last_name
                    ;
                }
            ],
            'date'
        ],
    ])?>