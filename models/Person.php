<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Phone;

class Person extends ActiveRecord
{
    public $id;
    public $first_name;
    public $last_name;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    public function getPhones()
    {
        return $this->hasMany(Phone::className(), [
            'person_id' => 'id',
        ]);
    }

    public static function tableName()
    {
        return '{{persons}}';
    }
}
