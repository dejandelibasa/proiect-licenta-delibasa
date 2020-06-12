<?php

namespace app\controllers;

use Yii;
use app\models\Portal;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PortalsController implements the CRUD actions for Portal model.
 */
class PortalsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Portal models.
     * @return mixed
     */
    public function actionIndex($portal_id)
    {
        $portal_object = Portal::findOne($portal_id);
        return $this->render('@app/views/' . $portal_object->getLowercaseName() . '/index.php', 
                            array('portal' => $portal_object));
    }
}