<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Job;
use app\models\Company;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */

$this->title = $this->params['portal']->name;
?>
<h1 style="color: <?= $this->params['portal']->getSecondaryColorAsHex() ?>"><?= $job->title ?></h1>
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
                <?= Yii::t('app', 'Contact email address: {0}', $companyContactDetails->email) ?>
            </p>
        </div>
        <div class="row" style="background-color: <?= $this->params['portal']->getPrimaryColorAsHex() ?>">
            <p style="color: <?= $this->params['portal']->getSecondaryColorAsHex() ?>">
                <?= Yii::t('app', 'Contact person: {0}', $companyContactDetails->contact_person_name) ?>
            </p>
        </div>
    </div>
</div>