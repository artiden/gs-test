<?php

namespace app\repositories;

use app\models\Person;
use app\models\Phone;

class PersonRepository
{

    /**
     * Get list of persons, based on search string and ordered by order
     * 
     * @param string $search
     * @param string $order <p>If first symbol is "-", the sorting direction will be set to "desc".</p>
     * <p>Default sorting direction is "DESC" by "id" field. (the newest items will be first.)</p>
     */
    public function getSortedPersons(?string $search = null, ?string $order = 'id')
    {
        $orderModeIsAsc = (false === stristr($order, '-'));
        $orderDefaultField = 'id';
        $orderMode = SORT_DESC;
        if ($orderModeIsAsc) {
            $orderMode = SORT_ASC;
        } else {
            //delete a first symbol "-" from a field name, when sorting direction is "DESC"
            $order = substr($order, 1);
        }

        // Array, which describes a model fields to sorting. As i understand, i can use array_keys($model->attributes), or like this. But i don't have many time to fully understand Yii :-)
        $allowedFields = [
            'id', 'firstName', 'lastName',
        ];

        $order = in_array($order, $allowedFields) ? $order : $orderDefaultField;

        $persons = Person::find()
        ->with('phones');

        //If search parameter is filled, add search to the query. I known, should use elasticSearch or Sphinx, but don't have a time to configure it in the containers and testing.
        if (!empty($search)) {
            $persons->where(['like', 'firstName', $search])
            ->orWhere(['like', 'lastName', $search]);
        }

        //add order and direction. We can use a column name from user input, because it has been checked before. (See allowedFields variable)
        $persons->orderBy([
            $order => $orderMode,
        ]);

        //Just return all results.
        return $persons->all();
    }

    /**
     * Saves a new person and it's phones. In regular project this saves must be splitted to differend functions and repositories.
     * 
     * @param string $firstName
     * @param string $lastName
     * @param array $phones
     * @throws \Exception
     * @return boolean
     */
    public function savePerson(string $firstName, string $lastName, array $phones)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $person = new Person();
            $person->firstName = $firstName;
            $person->lastName = $lastName;

            if (!$person->save()) {
                throw new \Exception();
            }

            foreach ($phones as $value) {
                $phone = new Phone();
                $phone->value = $value;
                //here can be used 'link()', but it's saves a record without validation and don't return success or error...
                $phone->personId = $person->id;

                if (!$phone->save()) {
                    throw new \Exception();
                }
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }

        return true;
    }
}
