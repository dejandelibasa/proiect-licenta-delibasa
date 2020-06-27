<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\forms\CompanyContactDetailsForm;

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
    <div class="col">
        <h1 class="portal-secondary-color">Add Job</h1>
        <?php
            $contactDetailsForm = ActiveForm::begin([
                'id' => 'company-contact-details-form',
                'options' => ['class' => 'form-vertical'],
            ]);
            echo $contactDetailsForm->field($contactDetailsFormModel,'telephone_number');
            echo $contactDetailsForm->field($contactDetailsFormModel, 'email');
            echo $contactDetailsForm->field($contactDetailsFormModel, 'ceo_name');
            echo $contactDetailsForm->field($contactDetailsFormModel, 'contact_person_name');
            echo Html::submitButton(Yii::t('app', 'Save company contact details'), ['class' => 'btn btn-primary form-group', 'value' => 'company_contact_details', 'name' => 'company_contact_details_submit']);
        ?>
        <?php ActiveForm::end() ?>
    </div>
</div>