<?php

namespace app\controllers;

use Yii;
use app\models\Portal;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\forms\SeekerRegisterForm;

/**
 * PortalsController implements the CRUD actions for Portal model.
 */
class PortalsController extends Controller
{
    public $layout = "portals";

    /**
     * Render index for portal with portal_id
     * @return mixed
     */
    public function actionIndex($portal_id)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);
        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/index.php');
    }

    /**
     * Render login for portal with portal_id
     * @return mixed
     */
    public function actionLogin($portal_id)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);
        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/login.php');
    }

    /**
     * Render register for portal with portal_id
     * @return mixed
     */
    public function actionRegister($portal_id)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);


        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/register.php', array(
            'seekerRegisterFormModel' => new SeekerRegisterForm()
        ));
    }
}