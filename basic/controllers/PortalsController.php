<?php

namespace app\controllers;

use Yii;
use app\models\Portal;
use app\models\User;
use app\models\Seeker;
use app\models\Company;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\forms\SeekerRegisterForm;
use app\models\forms\CompanyRegisterForm;
use app\models\forms\UserLoginForm;

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

        if(Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            if($data['user_login_submit'] == 'user_login') {
                $data = $data['UserLoginForm'];
                $user = User::find()->where(['email' => $data['email']])->one();
                if(password_verify($data['password'], $user->password)) {
                    Yii::$app->user->login($user);
                    return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/index.php');
                } else {
                    return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/login.php', array(
                        'userLoginFormModel' => new UserLoginForm(),
                        'error' => Yii::t('app', 'Password did not match account password'),
                    ));
                }
            } else {
                return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/login.php', array(
                    'userLoginFormModel' => new UserLoginForm(),
                    'error' => Yii::t('app', 'Unauthorized access to page'),
                ));
            }
        }

        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/login.php', array(
            'userLoginFormModel' => new UserLoginForm(),
            'error' => false,
        ));
    }

    /**
     * Log out the user with return to index
     * @return mixed
     */
    public function actionLogout($portal_id)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);
        Yii::$app->user->logout();
        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/index.php');
    }

    /**
     * Render register for portal with portal_id
     * @return mixed
     */
    public function actionRegister($portal_id)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);

        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $registrationType = $data['register_submit'];
            $user = new User();
            $user->portal_id = Yii::$app->view->params['portal']->id;
            switch($registrationType) {
                case 'company':
                    $data = $data['CompanyRegisterForm'];
                    $company = new Company();
                    $company->save();
                    $user->email = $data['email'];
                    $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
                    $user->entity_id = $company->id;
                    $user->type = User::USER_TYPE_COMPANY;
                    $company->name = $data['name'];
                    if($user->save() && $company->save()) {
                        Yii::$app->user->login($user);
                        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/company/profile.php');
                    } else {
                        $company->delete();
                        $user->delete();
                        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName(). '/register.php', array(
                            'seekerRegisterFormModel' => new SeekerRegisterForm(),
                            'companyRegisterFormModel' => new CompanyRegisterForm(),
                            'error' => Yii::t('app', 'Error creating new user. Please contact administrator'),
                        ));
                    }
                break;
                case 'seeker':
                    $data = $data['SeekerRegisterForm'];
                    $seeker = new Seeker();
                    $seeker->save();
                    $user->email = $data['email'];
                    $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
                    $user->entity_id = $seeker->id;
                    $user->type = User::USER_TYPE_SEEKER;
                    $seeker->first_name = $data['first_name'];
                    $seeker->last_name = $data['last_name'];
                    if ($user->save() && $seeker->save()) {
                        Yii::$app->user->login($user);
                        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/seeker/profile.php');
                    } else {
                        $seeker->delete();
                        $user->delete();
                        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName(). '/register.php', array(
                            'seekerRegisterFormModel' => new SeekerRegisterForm(),
                            'companyRegisterFormModel' => new CompanyRegisterForm(),
                            'error' => Yii::t('app', 'Error creating new user. Please contact administrator'),
                        ));
                    }
                break;
                default:
                    $this->actionIndex(Yii::$app->view->params['portal']->id);
                break;
            }
        }

        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/register.php', array(
            'seekerRegisterFormModel' => new SeekerRegisterForm(),
            'companyRegisterFormModel' => new CompanyRegisterForm(),
            'error' => false,
        ));
    }

    public function actionSeekerProfile($portal_id)
    {
        Yii::$app->view->params['portal'] = Portal::findOne($portal_id);
        return $this->render('@app/views/' . Yii::$app->view->params['portal']->getLowercaseName() . '/seeker/profile.php');
    }
}