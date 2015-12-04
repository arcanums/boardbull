<?php
namespace frontend\models;

use frontend\models\Image;
use common\models\User;
use yii\base\Model;
use Yii;
use yii\web\UploadedFile;

/**
 * Bulletin form
 */
class BulletinForm extends Model
{
    public $imageFile;
    public $title;
    public $description;

    public function rules()
    {
        return [
            [['title', 'description', 'imageFile'], 'required'],
            ['title', 'string', 'min' => 5, 'max' => 127],
            ['description', 'string', 'min' => 5, 'max' => 1024],
            ['imageFile', 'safe'],
            [['imageFile'], 'file', 'extensions'=>'jpg, gif, png'],
        ];
    }


    public function create()
    {
            $isValid = false;
            $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
            $user = User::findOne(Yii::$app->user->getId());
            $bulletin = new Bulletin();

            if( isset($this->imageFile)){
                $imagePath = '/uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
                $this->imageFile->saveAs(Yii::getAlias('@webroot') . $imagePath);
                $m_image = new Image();
                $m_image->url = $imagePath;


                if($m_image->save()){
                    $image = Image::findOne($m_image->getPrimaryKey());
                    $bulletin->link('image', $image );
                    $bulletin->link('user', $user );
                    $isValid = true;
                } else {
                    $isValid = false;
                }
            }

            $bulletin->title = $this->title;
            $bulletin->description = $this->description;

            if($bulletin->save()){
                $isValid = true;
            } else {
                $isValid = false;
            }

            return $isValid;
    }
}
