<?php

namespace app\controllers;

use Yii;
use app\models\Portal;
use app\models\User;
use app\models\Seeker;
use app\models\Company;
use app\models\Job;
use app\models\CompanyContactDetails;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\forms\AddJobForm;

class JobController extends Controller
{
    public $layout = 'portals';

    /**
     * Render adding job interface, and create Job for respective company
     * @return mixed
     */
    public function actionAdd($portal_id)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);

        if(Yii::$app->user->isGuest || Yii::$app->user->identity->type != User::USER_TYPE_COMPANY) {
            return $this->redirect(['portals/index', 'portal_id' => Yii::$app->view->params['portal']->id]);
        }

        if(Yii::$app->request->post()) {
            $job = new Job();
            $job->company_id = Yii::$app->user->identity->entity_id;
            $data = Yii::$app->request->post();
            $data = $data['AddJobForm'];
            $job->title = $data['title'];
            $job->description = $data['description'];
            $job->location = $data['location'];
            $job->created_at = date("Y-m-d H:i:s");
            if($job->save()) {
                return $this->redirect(['company/profile', 'portal_id' => Yii::$app->view->params['portal']->id]);
            } else {
                return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/job/addJob.php', array(
                    'addJobFormModel' => new AddJobForm(),
                    'error' => Yii::t('app', 'Error creating job'),
                ));
            }
        }

        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/job/addJob.php', array(
            'addJobFormModel' => new AddJobForm(),
            'error' => false,
        ));
    }

    /**
     * View a job given job_id
     * @return mixed
     */
    public function actionView($portal_id, $job_id, $error = null, $flash = null)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);

        $job = Job::findOne($job_id);
        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/job/viewJob.php', array(
            'job' => $job,
            'company' => Company::findOne($job->company_id),
            'companyContactDetails' => CompanyContactDetails::find()->where(['company_id' => $job->company_id])->one(),
            'flash' => $flash,
            'error' => $error,
        ));
    }

    /**
     * Render job editing interface
     * @return mixed
     */
    public function actionEdit($portal_id, $job_id)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);

        $job = Job::findOne($job_id);
        if(Yii::$app->user->identity->entity_id != $job->company_id) {
            return $this->redirect(['company/profile', 'portal_id' => Yii::$app->view->params['portal']->id]);
        }

        if(Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $data = $data['AddJobForm'];
            $job->title = $data['title'];
            $job->description = $data['description'];
            $job->location = $data['location'];
            if($job->save()) {
                return $this->redirect(['company/profile', 'portal_id' => Yii::$app->view->params['portal']->id]);
            } else {
                return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/job/editJob.php', array(
                    'editJobFormModel' => new AddJobForm(),
                    'error' => Yii::t('app', 'Error saving job changes'),
                ));
            }
        }

        $editJobForm = new AddJobForm();
        $editJobForm->title = $job->title;
        $editJobForm->description = $job->description;
        $editJobForm->location = $job->location;
        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/job/editJob.php', array(
            'editJobFormModel' => $editJobForm
        ));
    }

    /**
     * Delete a job given a job_id
     * @return mixed
     */
    public function actionDelete($portal_id, $job_id)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['portals/login', 'portal_id' => Yii::$app->view->params['portal']->id]);
        } elseif(Yii::$app->user->identity->entity_id != $job->company_id || Yii::$app->user->identity->entity_id != User::USER_TYPE_COMPANY) {
            return $this->redirect(['portals/index', 'portal_id' => Yii::$app->view->params['portal']->id]);
        }
        $job = Job::findOne($job_id);
        $job->delete();
        return $this->redirect(['company/profile', 'portal_id' => Yii::$app->view->params['portal']->id]);
    }
}