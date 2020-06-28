<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Job;
use app\models\Company;
use app\models\User;

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
    <?php $flash = isset($flash) ? $flash : false; ?>
	<?php if($flash): ?>
        <div class="alert alert-success" role="alert">
            <p>
                <?= $flash; ?>
            </p>
        </div>
    <?php endif; ?>
</div>
<div class="row">
    <div class="col-md-9">
        <h1 style="color: <?= $this->params['portal']->getSecondaryColorAsHex() ?>">
            <?= $job->title ?>
        </h1>
    </div>
    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->type == User::USER_TYPE_SEEKER): ?>
    <div class="col-md-3">
        <?= 
            Html::a(
                Yii::t('app', 'Click here to apply to job'),
                ['jobapplication/create', 'portal_id' => $this->params['portal']->id, 'job_id' => $job->id],
                [
                    'class' => 'btn',
                    'style' => [
                        'background-color' => Yii::$app->view->params['portal']->getPrimaryColorAsHex(),
                        'color' => Yii::$app->view->params['portal']->getSecondaryColorAsHex(),
                    ],
                ]
            )
        ?>
    </div>
    <?php endif; ?>
</div>

<p><?= Yii::t('app', 'Job posted at {0}', $job->created_at) ?></p>
<div clas="row">
    <div class="col-md-9">
        <div class="row">
            <p><?= $job->description ?></p>
        </div>
        <div class="row">
            <p><?= Yii::t('app', 'Job location: {0}', $job->location) ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="row">
            <h1 style="color: <?= $this->params['portal']->getSecondaryColorAsHex() ?>">
                <?= $company->name ?>
            </h1>
        </div>
        <div class="row" style="background-color: <?= $this->params['portal']->getPrimaryColorAsHex() ?>">
            <p style="color: <?= $this->params['portal']->getSecondaryColorAsHex() ?>">
                <?= Yii::t('app', 'Contact phone number: {0}', $companyContactDetails->telephone_number) ?>
            </p>
        </div>
        <div class="row" style="background-color: <?= $this->params['portal']->getPrimaryColorAsHex() ?>">
            <p style="color: <?= $this->params['portal']->getSecondaryColorAsHex() ?>">
                <?= 
                    Html::mailto(
                        Yii::t('app', 'Contact email address: {0}', $companyContactDetails->email), 
                        $companyContactDetails->email
                    )
                ?>
            </p>
        </div>
        <div class="row" style="background-color: <?= $this->params['portal']->getPrimaryColorAsHex() ?>">
            <p style="color: <?= $this->params['portal']->getSecondaryColorAsHex() ?>">
                <?= Yii::t('app', 'Contact person: {0}', $companyContactDetails->contact_person_name) ?>
            </p>
        </div>
    </div>
</div>