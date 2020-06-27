<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Company_contact_details".
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $email
 * @property string|null $telephone_number
 * @property string|null $contact_person_name
 * @property string|null $ceo_name
 *
 * @property Company $company
 */
class CompanyContactDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Company_contact_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id'], 'integer'],
            [['email', 'contact_person_name', 'ceo_name'], 'string', 'max' => 100],
            [['telephone_number'], 'string', 'max' => 16],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'email' => Yii::t('app', 'Contact Email'),
            'telephone_number' => Yii::t('app', 'Telephone Number'),
            'contact_person_name' => Yii::t('app', 'Contact Person Name'),
            'ceo_name' => Yii::t('app', 'Ceo Name'),
        ];
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
}
