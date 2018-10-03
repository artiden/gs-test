<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Person;

class Phone extends ActiveRecord
{
    /**
     * The entity id
     * @var int
     */
    public $id;
    /**
     * The phone value
     * @var string
     */
    public $value;

    public function getUser()
    {
        return $this->hasOne(Person::className(), [
            'id' => 'person_id',
        ]);
    }
}
