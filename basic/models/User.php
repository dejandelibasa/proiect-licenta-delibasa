<?php

namespace app\models;

use yii\web\IdentityInterface;

use Yii;

/**
 * This is the model class for table "User".
 *
 * @property int $id
 * @property int $type
 * @property int $entity_id
 * @property string $email
 * @property string $password
 *
 * @property Company $company
 * @property Seeker $seeker
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    CONST USER_TYPE_COMPANY = 1;
    CONST USER_TYPE_SEEKER = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'User';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'entity_id'], 'integer'],
            [['entity_id', 'email', 'password'], 'required'],
            [['email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 128],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'entity_id' => Yii::t('app', 'Entity ID'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
        ];
    }

    /**
     * Gets query for [[Entity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'entity_id']);
    }

    /**
     * Gets query for [[Entity0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeeker()
    {
        return $this->hasOne(Seeker::className(), ['id' => 'entity_id']);
    }

     /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
