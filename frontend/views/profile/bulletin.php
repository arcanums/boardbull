<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Your profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-sm-4">
            <div class="list-group">
                <?= Html::a('Profile', ['profile/index'], ['class' => 'list-group-item']) ?>
                <?= Html::a('My Bulletins', ['profile/bulletin'], ['class' => 'list-group-item active']) ?>
                <?= Html::a('Edit profile', ['profile/edit'], ['class' => 'list-group-item']) ?>
                <?= Html::a('Logout', ['site/logout'], ['class' => 'list-group-item', 'data-method' => 'post']) ?>
            </div>
        </div>
        <div class="col-sm-8">

            <h1>Add new bulletin</h1>
            <?php $form = ActiveForm::begin([
                'id'=>'bulletin-form',
                'options'=>[
                    'method'=> 'post',
                    'enctype' => 'multipart/form-data'
                    ],
                'action' => ['bulletin/create'],
            ]); ?>

            <?= $form->field($model, 'title') ?>

            <?= $form->field($model, 'description')->textArea(['rows' => '6']) ?>

            <?= $form->field($model, 'imageFile')->fileInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Add bulletin', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
            <hr>
            <div class="row">

                <?php foreach ($bulletins as $bulletin): ?>
                    <div class="media col-sm-12">

                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="<?= $bulletin->image->url; ?>" alt="<?= $bulletin->title; ?>" width="200px" >
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?= $bulletin->title; ?></h4>
                            <p><?= $bulletin->description; ?></p>
                            <hr style="margin-top: 8px; margin-bottom: 8px;">
                            <div><span class="pull-right"> <?= $bulletin->createdAt; ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
