<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

use app\models\Job;
use app\models\Seeker;
use app\models\User;
use app\models\CV;

/* @var $this yii\web\View */

$this->title = $this->params['portal']->name;
?>
<h1 style="color: <?= $this->params['portal']->getSecondaryColorAsHex() ?>">
    <?= Yii::t('app', 'Applications to your jobs') ?>
</h1>
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
                    $applicationSeekerId = User::findOne($model->user_id)->entity_id;
                    $applicationSeekerId = Seeker::findOne($applicationSeekerId)->id;
                    if(CV::find()->where(['seeker_id' => $applicationSeekerId])->one()) {
                        $cvFilePath = CV::find()->innerJoin('Seeker', 'Seeker.id = ' . $applicationSeekerId)->one()->path;
                    } else {
                        $cvFilePath = false;
                    }

                    if($cvFilePath) {
                        return Html::a(
                            Seeker::find()->innerJoin('User', 'User.id = ' . $model->user_id)->one()->first_name .
                            " " .
                            Seeker::find()->innerJoin('User', 'User.id = ' . $model->user_id)->one()->last_name,
                            [
                                'jobapplication/downloadcv', 
                                'cvPath' => $cvFilePath
                            ]
                        );
                    } else {
                        return Seeker::find()->innerJoin('User', 'User.id = ' . $model->user_id)->one()->first_name .
                                " " .
                                Seeker::find()->innerJoin('User', 'User.id = ' . $model->user_id)->one()->last_name;
                    }
                }
            ],
            'date'
        ],
    ])?>