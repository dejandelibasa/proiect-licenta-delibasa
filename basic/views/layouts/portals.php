<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use app\assets\AppAsset;
use app\models\User;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => $this->params['portal']->name,
        'brandUrl' => Url::toRoute(['portals/index', 'portal_id' => $this->params['portal']->id]),
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $navigationBarItems = [];
    if(Yii::$app->user->isGuest) {
        $navigationBarItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['portals/login', 'portal_id' => $this->params['portal']->id]];
        $navigationBarItems[] = ['label' => '/', 'url' => ''];
        $navigationBarItems[] = ['label' => Yii::t('app', 'Register'), 'url' => ['portals/register', 'portal_id' => $this->params['portal']->id]];
    } elseif(Yii::$app->user->identity->type == User::USER_TYPE_COMPANY) {
        $navigationBarItems[] = ['label' => Yii::t('app', 'Add Job'), 'url' => ['company/add_job.php', 'portal_id' => $this->params['portal']->id]];
        $navigationBarItems[] = ['label' => Yii::t('app', 'Profile'), 'url' => ['company/profile', 'portal_id' => $this->params['portal']->id]];
        $navigationBarItems[] = ['label' => Yii::t('app', 'Logout'), 'url' => ['portals/logout', 'portal_id' => $this->params['portal']->id]];
    } elseif(Yii::$app->user->identity->type == User::USER_TYPE_SEEKER) {
        $navigationBarItems[] = ['label' => Yii::t('app', 'Profile'), 'url' => ['seeker/profile', 'portal_id' => $this->params['portal']->id]];
        $navigationBarItems[] = ['label' => Yii::t('app', 'Logout'), 'url' => ['portals/logout', 'portal_id' => $this->params['portal']->id]];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $navigationBarItems,
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left"> Dejan Delibașa <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
