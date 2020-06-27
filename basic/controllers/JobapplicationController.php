<?php

namespace app\controllers;

use Yii;
use app\models\Portal;
use app\models\User;
use app\models\Seeker;
use app\models\Company;
use app\models\Job;
use app\models\JobApplication;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class JobapplicationController extends Controller
{
    public $layout = 'portals';

    /**
     * Create job application for current user
     * @return mixed
     */
    public function actionCreate($portal_id, $job_id)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);

        $flash = null;
        $error = null;

        $jobApplication = new JobApplication();
        $jobApplication->user_id = Yii::$app->user->identity->id;
        $jobApplication->job_id = $job_id;
        $jobApplication->date = date("Y-m-d H:i:s");

        if($jobApplication->save()) {
            $flash = Yii::t('app', 'Succesfully applied to job');
        } else {
            $error = Yii::t('app', 'Failed to apply to job');
        }

        return $this->redirect(['job/view', 'portal_id' => $portal_id, 'job_id' => $job_id, 'flash' => $flash, 'error' => $error]);
    }

    /**
     * List job applications for current seeker
     * @return mixed
     */
    public function actionSeeker($portal_id)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);

        if(Yii::$app->user->isGuest || Yii::$app->user->identity->type != User::USER_TYPE_SEEKER) {
            return $this->redirect(['portals/index', 'portal_id' => $portal_id]);
        }

        $jobApplications = new ActiveDataProvider([
            'query' => JobApplication::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy('date'),
        ]);

        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/jobapplication/seeker.php', array(
            'jobApplications' => $jobApplications,
            'error' => false,
        ));
    }

    /**
     * List job applications for current company
     * @return mixed
     */
    public function actionCompany($portal_id)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);

        if(Yii::$app->user->isGuest || Yii::$app->user->identity->type != User::USER_TYPE_COMPANY) {
            return $this->redirect(['portals/index', 'portal_id' => $portal_id]);
        }

        $jobApplications = new ActiveDataProvider([
            'query' => JobApplication::find()
                        ->innerJoin('Job', 'Job.company_id = ' . Yii::$app->user->identity->entity_id),
        ]);

        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/jobapplication/company.php', array(
            'jobApplications' => $jobApplications,
        ));
    }
}