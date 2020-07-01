<?php

namespace app\models;

use yii\helpers\FileHelper;

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
        $color = base_convert($color, 16, 2);
        $color = strlen($color) < 24 ? str_pad($color, 24, "0", STR_PAD_LEFT) : $color;
        return $color;
    }

    /**
     * @return string
     */
    public function getPrimaryColorAsHex()
    {
        $primaryColor = base_convert($this->primary_color, 2, 16);
        $primaryColor = strlen($primaryColor) < 6 ? str_pad($primaryColor, 6, "0", STR_PAD_LEFT) : $primaryColor;
        return '#' . $primaryColor;
    }
    /**
     * @return string
     */
    public function getSecondaryColorAsHex()
    {
        $secondaryColor = base_convert($this->secondary_color, 2, 16);
        $secondaryColor = strlen($secondaryColor) < 6 ? str_pad($secondaryColor, 6, "0", STR_PAD_LEFT) : $secondaryColor;
        return '#' . $secondaryColor;
    }
    
    /**
     * @return bool
     */
    public function createPortalViewsFolder()
    {
        FileHelper::copyDirectory(Yii::$app->basePath . "/views/portal_templates/", Yii::$app->basePath . "/views/" . $this->getLowercaseName());
        return true;
    }

    public function deletePortalViewsFolder()
    {
        FileHelper::removeDirectory(Yii::$app->basePath . "/views/" . $this->getLowercaseName());
    }
}
