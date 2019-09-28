<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "indicator".
 *
 * @property int $Id
 * @property string $IndicatorName
 * @property string $IndicatorSource
 *
 * @property IndicatorData[] $indicatorDatas
 * @property TargetIndicator[] $targetIndicators
 */
class Indicator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'indicator';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IndicatorName', 'IndicatorSource'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'IndicatorName' => 'Indicator Name',
            'IndicatorSource' => 'Indicator Source',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicatorDatas()
    {
        return $this->hasMany(IndicatorData::className(), ['IndicatorId' => 'Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTargetIndicators()
    {
        return $this->hasMany(TargetIndicator::className(), ['IndicatorId' => 'Id']);
    }
}
