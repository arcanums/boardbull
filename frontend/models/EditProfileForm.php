<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;
use yii\web\UploadedFile;

/**
 * EditProfile form
 */
class EditProfileForm extends Model
{
    public $firstname;
    public $lastname;
    public $aboutme;
    public $password;
    public $imageFile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['firstname', 'filter', 'filter' => 'trim'],
            ['firstname', 'string', 'max' => 64],

            ['lastname', 'filter', 'filter' => 'trim'],
            ['lastname', 'string', 'max' => 64],

            ['aboutme', 'filter', 'filter' => 'trim'],
            ['aboutme', 'string', 'max' => 1024],
//
//            ['password', 'required'],
//            ['password', 'string', 'min' => 6],

            ['imageFile', 'safe'],
            [['imageFile'], 'file', 'extensions'=>'jpg, gif, png'],
        ];
    }

    public function save()
    {
        if($this->validate()){

            $isValid = false;

            $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
            $user = User::findOne(Yii::$app->user->getId());

            if(isset($user->profile)){
                $profile = Profile::findOne($user->profile->id);
            } else {
                $profile = new Profile();
            }

            if( isset($this->imageFile)){
                $imagePath = '/uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
                $this->imageFile->saveAs(Yii::getAlias('@webroot') . $imagePath);
                $m_image = new Image();
                $m_image->url = $imagePath;


                if($m_image->save()){
                    $image = Image::findOne($m_image->getPrimaryKey());
                    $profile->link('image', $image );
                    $isValid = true;
                } else {
                    $isValid = false;
                }
            }

            $profile->firstname = $this->firstname;
            $profile->lastname = $this->lastname;
            $profile->aboutme = $this->aboutme;
            $profile->link('user', $user);

            if($profile->save()){
                $isValid = true;
            } else {
                $isValid = false;
            }

            return $isValid;
        } else {
            return false;
        }
    }
}
