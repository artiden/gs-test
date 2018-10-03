<?php

namespace app\models;

use yii\db\ActiveRecord;use app\models\Person;

class Phone extends ActiveRecord
{

    public function getUser()
    {
        return $this->hasOne(Person::className(), [
            'id' => 'personId',
        ]);
    }

    public static function tableName()
    {
        return '{{phones}}';
    }

    public function rules()
    {
        return [
            ['value', 'required'],
            ['value', 'string', 'max' => 255],
            ['value', 'trim'],
        ];
    }
}
