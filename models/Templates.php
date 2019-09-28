<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "templates".
 *
 * @property int $id
 * @property string $name
 * @property string $resp1
 * @property string $resp2
 */
class Templates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'templates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['resp1'], 'string', 'max' => 500],
            [['resp2'], 'string', 'max' => 3000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'resp1' => 'Resp1',
            'resp2' => 'Resp2',
        ];
    }
}
