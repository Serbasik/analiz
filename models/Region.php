<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property string $id
 * @property string $RegionName
 * @property string $okrug
 * @property int $BuildYear
 *
 * @property IndicatorData[] $indicatorDatas
 * @property Period $buildYear
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'RegionName', 'okrug'], 'required'],
            [['BuildYear'], 'integer'],
            [['id'], 'string', 'max' => 6],
            [['RegionName'], 'string', 'max' => 100],
            [['okrug'], 'string', 'max' => 4],
            [['id'], 'unique'],
            [['BuildYear'], 'exist', 'skipOnError' => true, 'targetClass' => Period::className(), 'targetAttribute' => ['BuildYear' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'RegionName' => 'Region Name',
            'okrug' => 'Okrug',
            'BuildYear' => 'Build Year',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicatorDatas()
    {
        return $this->hasMany(IndicatorData::className(), ['RegionId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuildYear()
    {
        return $this->hasOne(Period::className(), ['id' => 'BuildYear']);
    }
}
