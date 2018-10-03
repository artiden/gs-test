<?php

namespace app\controllers;
use yii\web\Controller;
use app\repositories\PersonRepository;
use app\models\Person;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

class PersonController extends Controller
{
    private $repository;
    
    public function __construct($id, $module, PersonRepository $repository, $config = [])
    {
        $this->repository = $repository;

        parent::__construct($id, $module, $config);
    }

    //use to disable CSRF validation. beforeAction does not work. See comment.
    public function init(){
        $this->enableCsrfValidation = false;

        parent::init();
    }

    /**
     * Displays all saved records
     * 
     * @return string
     */
    public function actionIndex()
    {
        $request = \Yii::$app->request;
        $search = $request->get('q', null);
        $order = $request->get('order', null);

        $persons = $this->repository->getSortedPersons($search, $order);

        return $this->render('list', compact('persons'));
    }

    /**
     * Save new record
     * 
     */
    public function actionSave()
    {
        //fetch json data. Configure to handle application/json content-type by yii\web\JsonParser make an 500 error. See config/web
        $request = \Yii::$app->request;
        $data = Json::decode($request->getRawBody(), true);
        $firstName = ArrayHelper::getValue($data, 'firstName', null);
        $lastName = ArrayHelper::getValue($data, 'lastName', null);
        $phones = ArrayHelper::getValue($data, 'phoneNumbers', []);

        $saveResult = $this->repository->savePerson($firstName, $lastName, $phones);

        \Yii::$app->response->setStatusCode($saveResult ? 200 : 400);
        \Yii::$app->response->send();
    }

    /*
     * It dont work. If uncomment it, return an empty response
    
    public function beforeAction($action)
    {
        if ('save' == $action->id) {
            $this->enableCsrfValidation = false;
        }

        parent::beforeAction($action);
    }
    */
}
