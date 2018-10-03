<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Phone;

class Person extends ActiveRecord
{

    public function getPhones()
    {
        return $this->hasMany(Phone::className(), [
            'personId' => 'id',
        ]);
    }

    public static function tableName()
    {
        return '{{persons}}';
    }

    public function rules()
    {
        return [
            [['firstName', 'lastName'], 'required'],
            [['firstName', 'lastName'], 'string', 'max' => 255],
            [['firstName', 'lastName'], 'trim'],
        ];
    }
}
