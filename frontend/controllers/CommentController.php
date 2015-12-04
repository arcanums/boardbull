<?php

namespace frontend\controllers;

use Yii;

use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Profile;
use frontend\models\Comment;
use common\models\User;

class CommentController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['comment'],
                'rules' => [

                    [
                        'actions' => ['comment'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'comment' => ['post'],
                ],
            ],
        ];
    }

    public function actionComment()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();

            $user = User::findOne(Yii::$app->user->getId());

            $whom = User::findOne($data['whom_id']);
            $rate = $whom->profile->rate;

            if($rate == 0){
                $whom->profile->rate = (float)$data['rate'];
            }else{
                $whom->profile->rate = ($rate + (float)$data['rate'])/2;
            }
            $whom->profile->save();

            $comment = new Comment();
            $comment->rate = $data['rate'];
            $comment->description = $data['comment'];
            $comment->whom_id = $data['whom_id'];
            $comment->link('owner', $user);
            if($comment->save()){
                return array(
                    'success' => true
                );
            }
            return array(
                'success' => false
            );
        }
    }
}
