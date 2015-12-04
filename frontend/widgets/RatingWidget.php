<?php
namespace frontend\widgets;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\AssetBundle;
use yii\web\View;

class RatingWidget extends InputWidget
{
    public $widgetId;
    public $rate;
    public $options = [];

    private $_assetBundle;
    private $_defaultOptions = [
        'showTodayButton' => true
    ];

    public function init()
    {
        $this->registerScript();
    }

    public function run()
    {
        echo "<div><input ratting='".(int)$this->rate."' id='input-".$this->widgetId."' rat-id='".$this->widgetId."' name='rat-".$this->widgetId."' type='number' class='rating' min=0 max=5 step=1 data-size='xs' >"
            .'
            <div id=\'comment-' . $this->widgetId.'\' class="hide rat" >
                <div class="form-group">
                    <input type="text" id="comment-'.$this->widgetId.'" name="comment-'.$this->widgetId.'" class="form-control" placeholder="Type something…" rows="3">
                </div>
                <button onclick="comment.add(\''.$this->widgetId.'\', $(this).parent().find(\'#comment-'.$this->widgetId.'\').val(), $(this).parent().parent().parent().find(\'#input-'.$this->widgetId.'\').val() );" class="btn btn-primary btn-block">Submit</button>
                <button onclick="$(this).parent().addClass(\'hide\');" class="btn btn-default btn-block">Cancel</button>
            </div>
            </div>
            ' ;
    }

    public function registerScript()
    {
        $this->getView()->registerJs('
        $(document).ready(function(){
            $("input[name*=\'rat-\']").each(function(){
                $(this).rating("update", $(this).attr("ratting") );
            });

            if('.((!\Yii::$app->user->isGuest)?('true'):('false')).'){
                 $("input[rat-id=\''. Yii::$app->user->getId() . '\']").rating("refresh", {disabled: true, showClear: false});
            } else {
                  $("input[name*=\'rat-\']").rating("refresh", {disabled: true, showClear: false});
            }
        });
        $("input[name*=\'rat-\']").on(\'change\', function(event, value, caption) {
            var id = $(this).attr(\'rat-id\');

            $(this).parent().parent().parent().find("#comment-" + id).removeClass("hide");

            $("input[rat-id=\'" + id +"\']").rating(\'update\', this.value );
            $("input[rat-id=\'" + id +"\']").rating(\'refresh\', {disabled: true, showClear: false});
        });
        ', View::POS_END);
        $this->getView()->registerJs('
            var comment = {
                \'add\': function(whom_id, comment, rate) {
                    $.ajax({
                        url: \''. Url::to(['comment/comment']) .'\',
                        type: \'post\',
                        data: \'whom_id=\' + whom_id + \'&rate=\' + rate + \'&comment=\' + comment,
                        dataType: \'json\',
                        beforeSend: function() {
                         //$(this).parent().addClass("hide");
                        },
                        success: function(json) {
                            if(json["success"]){
                                  $("[id*=\'comment-\']").hide();
                            }
                        }
                    });
                }
            };

        ', View::POS_HEAD);
    }

    public function registerAssetBundle()
    {
        $this->_assetBundle = RatingWidgetAsset::register($this->getView());
    }

    public function getAssetBundle()
    {
        if (!($this->_assetBundle instanceof AssetBundle)) {
            $this->registerAssetBundle();
        }
        return $this->_assetBundle;
    }

}
