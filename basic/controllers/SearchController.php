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
use app\models\forms\JobSearchForm;

class SearchController extends Controller
{
    public $layout = 'portals';

    /**
     * Renders job searching view according to parameters that were sent
     * @return mixed
     */
    public function actionJob($portal_id)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);
        $search_data = Yii::$app->getRequest()->getQueryParam('search_data');
        $jobsDataProviderPagination = ['pageSize' => 10];

        $jobsQuery = Job::find();

        $titleQueryArray = isset($search_data['title']) && !empty($search_data['title']) ? ['title' => $search_data['title']] : false;
        $locationQueryArray = isset($search_data['location']) && !empty($search_data['location']) ? ['location' => $search_data['location']] : false;

        if($titleQueryArray) {
            $jobsQuery->where($titleQueryArray);
        }
        if($locationQueryArray) {
            $jobsQuery->orWhere($locationQueryArray);
        }
        $jobsQuery->orderBy('created_at');

        $jobsDataProvider = new ActiveDataProvider([
            'query' => $jobsQuery,
            'pagination' => $jobsDataProviderPagination,
        ]);

        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/search/searchJob.php', array(
            'jobSearchFormModel' => new JobSearchForm(),
            'jobsDataProvider' => $jobsDataProvider,
            'error' => 'false',
        ));
    }
}