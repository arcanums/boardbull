<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use frontend\widgets\RatingWidget;
/* @var $this yii\web\View */

$this->title = 'Bulletin board';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Welcome to Bulletin board</h1>
        <p>Create your bulletin just press the button below</p>
        <p><?= Html::a('Create Bulletin', ['profile/bulletin'], ['class' => 'btn btn-lg btn-success']) ?></p>
    </div>
    <div class="body-content">
        <div class="row">

            <?php foreach ($bulletins as $bulletin): ?>
            <div class="media col-sm-8 col-sm-offset-2">

                    <div class="media-left">
                        <a href="#">
                            <img class="media-object" src="<?= $bulletin->image->url; ?>" alt="<?= $bulletin->title; ?>" width="200px" >
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading"><?= $bulletin->title; ?></h4>
                        <p><?= $bulletin->description; ?></p>
                        <hr style="margin-top: 8px; margin-bottom: 8px;">
                        <div>
                            <span class="pull-right"> <?= $bulletin->createdAt; ?></span>
                            <div class="pull-left"><?= Html::a('<span class="glyphicon glyphicon-user"></span> <b>' .  $bulletin->user->username .  '</b>', ['profile/view', 'id' => $bulletin->user->id]) ?>
                            <?= RatingWidget::widget(['widgetId'=> $bulletin->user->id, 'rate'=> $bulletin->user->profile->rate ]); ?></div>
                        </div>
                    </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <?= LinkPager::widget(['pagination' => $pagination]) ?>
            </div>
        </div>
            </div>
</div>

