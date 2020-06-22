<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Portal".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $primary_color
 * @property string|null $secondary_color
 */
class Portal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Portal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 64],
            [['primary_color', 'secondary_color'], 'string', 'max' => 24],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'primary_color' => Yii::t('app', 'Primary Color'),
            'secondary_color' => Yii::t('app', 'Secondary Color'),
        ];
    }

    /**
     * returns lowercase name of portal
     * @return string
     */
    public function getLowercaseName()
    {
        return strtolower($this->name);
    }

    /**
     * @return string
     */
    public function convertColorRGBtoHex($color)
    {
        $color = explode('#', $color);
        $color = $color[1];
        return base_convert($color, 16, 2);
    }

    /**
     * @return string
     */
    public function getPrimaryColorAsHex()
    {
        return base_convert($this->primary_color, 2, 16);
    }
    /**
     * @return string
     */
    public function getSecondaryColorAsHex()
    {
        return base_convert($this->secondary_color, 2, 16);
    }

    public function createPortalViewsFolder()
    {
        mkdir(Yii::$app->basePath . "/views/" . $this->getLowercaseName());
    }

    public function deletePortalViewsFolder()
    {
    }

    public function createPortalCSSFile()
    {
    }
    public function deletePortalCSSFile()
    {
    }
}
