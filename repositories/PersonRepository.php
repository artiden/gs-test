<?php

namespace app\repositories;

use app\models\Person;

class PersonRepository
{
    
    /**
     * Get list of persons, based on search string and ordered by order
     * 
     * @param string $search
     * @param string $order <p>If first symbol is "-", the sorting direction will be set to "desc".</p>
     * <p>Default sorting direction is "DESC" by "id" field. (the newest items will be first.)</p>
     */
    public function getSortedPersons(?string $search = null, string $order = 'id')
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
            'id', 'first_name', 'last_name',
        ];

        $order = in_array($order, $allowedFields) ? $order : $orderDefaultField;

        $persons = Person::find();

        //If search parameter is filled, add search to the query. I known, should use elasticSearch or Sphinx, but don't have a time to configure it in the containers and testing.
        if (!empty($search)) {
            $persons->where(['like', 'first_name', $search])
            ->orWhere(['like', 'last_name', $search]);
        }

        //add order and direction. We can use a column name from user input, because it has been checked before. (See allowedFields variable)
        $persons->orderBy([
            $order => $orderMode,
        ]);

        //Just return all results.
        return $persons->all();
    }
}
