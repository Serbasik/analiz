<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "period".
 *
 * @property int $id
 *
 * @property IndicatorData[] $indicatorDatas
 * @property Region[] $regions
 * @property TargetIndicator[] $targetIndicators
 */
class Period extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'period';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicatorDatas()
    {
        return $this->hasMany(IndicatorData::className(), ['Year' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegions()
    {
        return $this->hasMany(Region::className(), ['BuildYear' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTargetIndicators()
    {
        return $this->hasMany(TargetIndicator::className(), ['Year' => 'id']);
    }
}
