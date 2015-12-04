<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\RatingWidget;

$this->title = $user->username;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2" >
            <div class="media">
                <div class="media-left media-middle">
                    <a href="#">
                            <img class="media-object" class="img-thumbnail" src="<?=  $user->image->url; ?>" alt="<? $user->username; ?>" width="200px" height="200px" >
                    </a>
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
                        <tr>
                            <td>First name:</td>
                            <td><?= (isset($user->profile))?($user->profile->firstname):('none'); ?></td>
                        </tr>
                        <tr>
                            <td>Last name:</td>
                            <td><?= ($user->profile)?($user->profile->lastname):('none'); ?></td>
                        </tr>
                        <tr>
                            <td>About me</td>
                            <td><?= ($user->profile)?($user->profile->aboutme):('none'); ?></td>
                        </tr>
                        </tbody>
                    </table>
                    <br>
                </div>


                <?php if( isset($user->comments) ): ?>
                    <hr>
                    <?php foreach ($user->comments as $comment): ?>
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <a href="#">
                                        <img class="media-object" class="img-thumbnail" src="<?= $comment->owner->image->url ?>" alt="<?= $comment->owner->username ?>" width="100px" height="100px" >
                                    </a>
                                    <p> <?= RatingWidget::widget(['widgetId'=> $comment->owner->id, 'rate'=> (isset($comment->owner->profile))?($comment->owner->profile->rate):(0) ]); ?>
                                    </p>
                                    <p><i class="glyphicon glyphicon-user"></i><?= $comment->owner->username; ?></p>
                                </a>
                            </div>
                            <div class="media-body">
                                <p class="well"><?= $comment->description; ?> </p>
                                <span class="pull-right"><?= $comment->createdAt; ?></span>
                                <span class="pull-left"><?= $comment->rate; ?></span>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>


                <?php if( isset($user->bulletins) ): ?>
                <hr>
                    <?php foreach ($user->bulletins as $bulletin): ?>
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
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
