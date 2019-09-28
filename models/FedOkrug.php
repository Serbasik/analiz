<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fed_okrug".
 *
 * @property string $Id
 * @property string $OkrugShortName
 * @property string $OkrugName
 */
class FedOkrug extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fed_okrug';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id'], 'required'],
            [['Id', 'OkrugShortName'], 'string', 'max' => 4],
            [['OkrugName'], 'string', 'max' => 100],
            [['Id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'OkrugShortName' => 'Okrug Short Name',
            'OkrugName' => 'Okrug Name',
        ];
    }
}
