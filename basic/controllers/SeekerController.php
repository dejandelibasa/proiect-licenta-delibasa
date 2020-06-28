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
use yii\web\UploadedFile;
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
            return $this->redirect(['portals/login', 'portal_id' => $portal_id]);
        } elseif(Yii::$app->user->identity->type != User::USER_TYPE_SEEKER) {
            return $this->redirect(['portals/index', 'portal_id' => $portal_id]);
        }

        $seekerUploadCVFormModel = new SeekerUploadCvForm();
        $cv = CV::find()->where(['seeker_id' => Yii::$app->user->identity->entity_id])->one();
        $cv = isset($cv) ? $cv : new CV();
        if(Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $data = $data['seeker_profile_submit'];
            switch($data) {
                case 'upload_cv':
                    $seekerUploadCVFormModel->CV = UploadedFile::getInstance($seekerUploadCVFormModel, 'CV');
                    $seekerUploadCVFormModel->seeker_id = Yii::$app->user->identity->entity_id;
                    $cv->seeker_id = Yii::$app->user->identity->entity_id;
                    $cv->path = 
                                '@app/uploads/seeker_cvs/' . 
                                Yii::$app->user->identity->entity_id . 
                                '/' . 
                                $seekerUploadCVFormModel->CV->baseName . 
                                '.' . 
                                $seekerUploadCVFormModel->CV->extension;
                    $uploadDir = Yii::$app->basePath . '/uploads/seeker_cvs/' . Yii::$app->user->identity->entity_id;
                    if(!is_dir($uploadDir)) {
                        mkdir($uploadDir);
                    } else {
                        $filesInSeekerUploadDirectory = scandir($uploadDir);
                        foreach ($filesInSeekerUploadDirectory as $file) { 
                            if ($file != "." && $file != "..") {
                                unlink($uploadDir . '/' . $file);
                            }
                        }
                    }
                    $cv->updated_at = date("Y-m-d H:i:s");
                    if(!$cv->save()) {
                        $error = Yii::t('app', 'Error creating cv file.');
                    }
                    if(!$seekerUploadCVFormModel->upload()) {
                        $error = Yii::t('app', 'Error uploading cv file.');
                    }
                break;
                default:
                    return $this->redirect(['portals/index', 'portal_id' => $portal_id]);
                break;
            }
        }

        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/seeker/profile.php', array(
            'seekerUploadCVFormModel' => $seekerUploadCVFormModel,
            'cv' => $cv,
            'error' => isset($error) ? $error : false,
        ));
    }
}
