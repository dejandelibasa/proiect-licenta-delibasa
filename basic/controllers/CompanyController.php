<?php

namespace app\controllers;

use Yii;
use app\models\Portal;
use app\models\User;
use app\models\Seeker;
use app\models\Company;
use app\models\Job;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class CompanyController extends Controller
{
    public $layout = 'portals';

    /**
     * Decides which type of users can access views in controller
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Render company profile for portal with portal_id
     * @return mixed
     */
    public function actionProfile($portal_id)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);

        $last_5_jobs = new ActiveDataProvider([
            'query' => Job::find()->where(['company_id' => Yii::$app->user->identity->entity_id])->orderBy('created_at')->limit(5),
        ]);

        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/company/profile.php', array(
            'last_5_jobs' => $last_5_jobs,
            'error' => false,
        ));
    }
}