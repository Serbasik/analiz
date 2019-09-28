<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "indicator_data".
 *
 * @property int $id
 * @property string $RegionId
 * @property int $Year
 * @property int $IndicatorId
 * @property string $value
 *
 * @property Indicator $indicator
 * @property Period $year
 * @property Region $region
 */
class IndicatorData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'indicator_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['RegionId', 'Year', 'IndicatorId'], 'required'],
            [['Year', 'IndicatorId'], 'integer'],
            [['value'], 'number'],
            [['RegionId'], 'string', 'max' => 6],
            [['IndicatorId'], 'exist', 'skipOnError' => true, 'targetClass' => Indicator::className(), 'targetAttribute' => ['IndicatorId' => 'Id']],
            [['Year'], 'exist', 'skipOnError' => true, 'targetClass' => Period::className(), 'targetAttribute' => ['Year' => 'id']],
            [['RegionId'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['RegionId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'RegionId' => 'Region ID',
            'Year' => 'Year',
            'IndicatorId' => 'Indicator ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicator()
    {
        return $this->hasOne(Indicator::className(), ['Id' => 'IndicatorId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYear()
    {
        return $this->hasOne(Period::className(), ['id' => 'Year']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'RegionId']);
    }
}
