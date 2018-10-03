<?php

namespace app\controllers;
use yii\web\Controller;
use app\repositories\PersonRepository;

class PersonController extends Controller
{
    //public $modelClass = 'app\models\Person';
    private $repository;
    
    public function __construct($id, $module, PersonRepository $repository, $config = [])
    {
        $this->repository = $repository;

        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $persons = $this->repository->getSortedPersons();
        return $this->render('list', compact('persons'));
    }
}
