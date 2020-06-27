<?php
namespace app\models\forms;

use yii\base\Model;
use yii\web\UploadedFile;

class SeekerUploadCvForm extends \yii\base\Model
{
    /**
     * @var UploadedFile
     */
    public $CV;
    public $seeker_id;

    public function rules()
    {
        return [
            [['CV'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->CV->saveAs('@app/uploads/seeker_cvs/' . $this->seeker_id . '/' . $this->CV->baseName . '.' . $this->CV->extension);
            return true;
        } else {
            return false;
        }
    }
}