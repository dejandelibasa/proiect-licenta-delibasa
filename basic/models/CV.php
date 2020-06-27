<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CV".
 *
 * @property int $id
 * @property int $seeker_id
 * @property string|null $path
 *
 * @property Seeker $seeker
 */
class CV extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'CV';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['seeker_id'], 'required'],
            [['seeker_id'], 'integer'],
            [['path'], 'string', 'max' => 100],
            [['seeker_id'], 'exist', 'skipOnError' => true, 'targetClass' => Seeker::className(), 'targetAttribute' => ['seeker_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'seeker_id' => Yii::t('app', 'Seeker ID'),
            'path' => Yii::t('app', 'Path'),
        ];
    }

    /**
     * Gets query for [[Seeker]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeeker()
    {
        return $this->hasOne(Seeker::className(), ['id' => 'seeker_id']);
    }
}
