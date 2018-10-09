<?php

namespace app\jobs;

use app\repositories\PersonRepository;

class SaveInfoJob implements \yii\queue\Job
{
    /**
     * Represent first name of person, which be saved
     * 
     * @var string
     */
    public $firstName;

    /**
     * Represent last name of person, which be saved
     * 
     * @var string
     */
    public $lastName;

    /**
     * Represent phone numbers of person, which be saved
     * 
     * @var array
     */
    public $phones;

    /**
     * Constructor...
     * 
     * @param string $firstName
     * @param string $lastName
     * @param array $phones
     */
    public function __construct(string $firstName, string $lastName, array $phones)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phones = $phones;
    }

    /**
     * Run queued job
     * 
     * @param unknown_type $queue
     */
    public function execute($queue)
    {
        return (new PersonRepository)->savePerson($this->firstName, $this->lastName, $this->phones);
    }
}
