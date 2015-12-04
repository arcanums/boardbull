<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\widgets\RatingWidget;

$this->title = 'Your profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-sm-4">
            <div class="list-group">
                <?= Html::a('Profile', ['profile/index'], ['class' => 'list-group-item']) ?>
                <?= Html::a('My Bulletins', ['profile/bulletin'], ['class' => 'list-group-item']) ?>
                <?= Html::a('Edit profile', ['profile/edit'], ['class' => 'list-group-item active']) ?>
                <?= Html::a('Logout', ['site/logout'], ['class' => 'list-group-item', 'data-method' => 'post']) ?>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="media">
                <div class="media-left media-middle">
                        <img class="media-object" class="img-thumbnail" src="<?=  $user->image->url; ?>" alt="<? $user->username; ?>" width="200px" height="200px" >
                    <p><?= RatingWidget::widget(['widgetId'=>$user->id, 'rate'=> (isset($user->profile))?($user->profile->rate):(0) ]); ?></p>
                </div>
                <div class="media-body">
                    <table class="table description">
                        <tbody>
                        <tr>
                            <td>Login:</td>
                            <td><b><?= $user->username; ?></b></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><?= $user->email; ?></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                </div>
            <hr>
            <?php $form = ActiveForm::begin([
                'id'=>'profile-form',
                'options'=>[
                    'method'=> 'post',
                    'enctype' => 'multipart/form-data'
                ],
            ]); ?>

            <?= $form->field($model, 'firstname') ?>

            <?= $form->field($model, 'lastname') ?>

            <?= $form->field($model, 'aboutme')->textArea(['rows' => '6']) ?>

            <?= $form->field($model, 'imageFile')->fileInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
