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
use app\models\forms\CompanyContactDetailsForm;

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

    /**
     * Render company contact details form for portal with portal_id and save input data
     * @return mixed
     */
    public function actionContact($portal_id)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);

        if(Yii::$app->user->isGuest) {
            return $this->redirect(['portals/login', 'portal_id' => Yii::$app->view->params['portal']->id]);
        } elseif(Yii::$app->user->identity->portal_id != $portal_id) {
            return $this->redirect(['company/contact', 'portal_id' => Yii::$app->user->identity->portal_id]);
        }

        $queriedDetails = CompanyContactDetails::find()->where(['company_id' => Yii::$app->user->identity->entity_id])->one();
        $companyContactDetailsForm = new CompanyContactDetailsForm();
        if(isset($queriedDetails)) {
            $companyContactDetailsForm->email = $queriedDetails->email;
            $companyContactDetailsForm->telephone_number = $queriedDetails->telephone_number;
            $companyContactDetailsForm->ceo_name = $queriedDetails->ceo_name;
            $companyContactDetailsForm->contact_person_name = $queriedDetails->contact_person_name;
        }

        if(Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            if(isset($data['company_contact_details_submit'])) {
                $data = $data['CompanyContactDetailsForm'];
                $companyContactDetails = new CompanyContactDetails();
                $companyContactDetails->company_id = Yii::$app->user->identity->entity_id;
                $companyContactDetails->telephone_number = $data['telephone_number'];
                $companyContactDetails->email = $data['email'];
                $companyContactDetails->ceo_name = $data['ceo_name'];
                $companyContactDetails->contact_person_name = $data['contact_person_name'];
                if($companyContactDetails->save()) {
                    return $this->redirect(['company/profile', 'portal_id' => Yii::$app->user->identity->portal_id]);
                } else {
                    return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/company/contactDetails.php', array(
                        'contactDetailsFormModel' => $companyContactDetailsForm,
                        'error' => Yii::t('app', 'Error encountered saving the details, please try again.'),
                    ));
                }
            } else {
                return $this->redirect(['portals/index', 'portal_id' => Yii::$app->user->identity->portal_id]);
            }
        }

        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/company/contactDetails.php', array(
            'contactDetailsFormModel' => $companyContactDetailsForm,
            'error' => false,
        ));
    }
}