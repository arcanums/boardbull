<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\BulletinForm;


/**
 * Bulletin controller
 */
class BulletinController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    'delete' => ['post'],
                ],
            ],

        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new BulletinForm();
        if ($model->load(Yii::$app->request->post())) {
            if($model->create()){
                Yii::$app->session->setFlash('success', 'New bulletin was successfully added');
            } else {
                Yii::$app->session->setFlash('error', 'Bulletin was not saved');
            }
        }
       return $this->redirect(\Yii::$app->request->getReferrer());
    }

    public function actionDelete()
    {
        return $this->goBack();
    }
}
