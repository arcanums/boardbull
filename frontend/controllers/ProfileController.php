<?php

namespace frontend\controllers;

use Yii;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\BulletinForm;
use frontend\models\Bulletin;
use frontend\models\Profile;
use frontend\models\EditProfileForm;
use common\models\User;
use yii\data\Pagination;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['bulletin', 'index', 'save', 'edit'],
                'rules' => [

                    [
                        'actions' => ['bulletin', 'index', 'save', 'edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'save' => ['post'],
                ],
            ],
        ];
    }

    public function actionBulletin()
    {
        $bulletinForm = new BulletinForm();
        $query = Bulletin::find()->where(['user_id' => YII::$app->user->getId()]);

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $bulletins = $query->orderBy('created_at')->orderBy(['created_at'=>SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render( 'bulletin', [
                'model' => $bulletinForm,
                'bulletins' => $bulletins,
                'pagination' => $pagination,
            ]);
    }

    public function actionEdit()
    {
        $model = new EditProfileForm();
        $user = User::findOne(YII::$app->user->getId());

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Profile was success edited');

            } else {
                Yii::$app->session->setFlash('error', 'error is ongoing');
            }
        }

        if(isset($user->profile)){
            $model->firstname = $user->profile->firstname;
            $model->lastname = $user->profile->lastname;
            $model->aboutme = $user->profile->aboutme;
        }
        if(isset($user->image)){
            $model->imageFile = $user->image;
        }

        return $this->render('edit',[
                'model' =>  $model,
                'user' => $user
        ]);
    }

    public function actionIndex()
    {
        $user = User::findOne(YII::$app->user->getId());
        return $this->render('index',[
            'user'=>$user
        ]);
    }

    public function actionView($id)
    {
        $user = User::findOne($id);

        return $this->render( 'view', [
            'user' => $user,
        ]);

    }


}
