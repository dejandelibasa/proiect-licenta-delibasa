<?php

namespace app\controllers;

use Yii;
use app\models\Portal;
use app\models\User;
use app\models\Seeker;
use app\models\Company;
use app\models\CV;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\forms\SeekerUploadCvForm;

class SeekerController extends Controller
{
    public $layout = 'portals';

    /**
     * Render seeker profile for portal with portal_id
     * @return mixed
     */
    public function actionProfile($portal_id)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);

        if(Yii::$app->user->isGuest) {
            return $this->redirect(['portals/login', 'portal_id', $portal_id]);
        } elseif(Yii::$app->user->identity->type != User::USER_TYPE_SEEKER) {
            
        }

        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/seeker/profile.php', array(
            'seekerUploadCVFormModel' => new SeekerUploadCvForm(),
            'error' => false,
        ));
    }
}