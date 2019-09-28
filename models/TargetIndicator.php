<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "target_indicator".
 *
 * @property int $id
 * @property int $Year
 * @property int $IndicatorId
 * @property string $TargetValue
 *
 * @property Indicator $indicator
 * @property Period $year
 */
class TargetIndicator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'target_indicator';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Year', 'IndicatorId'], 'required'],
            [['Year', 'IndicatorId'], 'integer'],
            [['TargetValue'], 'number'],
            [['IndicatorId'], 'exist', 'skipOnError' => true, 'targetClass' => Indicator::className(), 'targetAttribute' => ['IndicatorId' => 'Id']],
            [['Year'], 'exist', 'skipOnError' => true, 'targetClass' => Period::className(), 'targetAttribute' => ['Year' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Year' => 'Year',
            'IndicatorId' => 'Indicator ID',
            'TargetValue' => 'Target Value',
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
}
