<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Seeker".
 *
 * @property int $id
 *
 * @property Cv[] $cvs
 * @property User[] $users
 */
class Seeker extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Seeker';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
        ];
    }

    /**
     * Gets query for [[Cvs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCvs()
    {
        return $this->hasMany(Cv::className(), ['seeker_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['entityid' => 'id']);
    }
}
