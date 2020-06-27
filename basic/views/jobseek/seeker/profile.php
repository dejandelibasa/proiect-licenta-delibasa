<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

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

<?php if(isset($cv->path)): ?>
	<h1><?= Yii::t('app', 'Current CV') ?></h1>
	<?php 
		$cvName = $cv->path;
		$cvName = explode('/', $cvName);
		$cvName = array_pop($cvName);
	?>
	<?=
		DetailView::widget([
			'model' => $cv,
			'attributes' => [
				[
					'label' => Yii::t('app', 'Cv Name'),
					'value' => $cvName,
				],
				'updated_at',
			],
		])
	?>
	<p>
		<?= Html::button(
						Yii::t('app', 'Press to update CV'), 
						[
							'class' => 'btn',
							'style' => 'background-color: ' . Yii::$app->view->params['portal']->getPrimaryColorAsHex() . '; color:' . Yii::$app->view->params['portal']->getSecondaryColorAsHex() . ';',
							'type' => 'button',
							'data' => ['toggle' => 'collapse', 'target' => '#cv-collapse'],
							'aria' => ['expanded' => 'false', 'controls' => 'cv-collapse'],
						],
		)?>
	</p>
	<div class="collapse" id="cv-collapse">
  	<div class="card card-body">
<?php endif; ?>
<?php $seekerUploadCvForm = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
	<?= $seekerUploadCvForm->field($seekerUploadCVFormModel, 'CV')->fileInput() ?>
	<?= Html::submitButton(
													Yii::t('app', 'Upload CV'), 
													['class' => 'btn btn-primary form-group', 'value' => 'upload_cv', 'name' => 'seeker_profile_submit']); 
	?>
<?php ActiveForm::end() ?>
<?php if(isset($cv->path)): ?>
		</div>
	</div>
<?php endif; ?>