<?php

namespace App;

use Faker\Generator;
use Faker\Provider\{
    Internet, Person, DateTime, Miscellaneous, Lorem
};

class Factory
{

    private static $instance;

    private $definitions = [];

    private $lastClass;

    private $fakerInstance;

    private function __construct() {

        $faker = new Generator();

        $faker->addProvider(new Internet($faker));
        $faker->addProvider(new Person($faker));
        $faker->addProvider(new DateTime($faker));
        $faker->addProvider(new Miscellaneous($faker));
        $faker->addProvider(new Lorem($faker));

        $this->fakerInstance = $faker;

    }

    public static function getInstance($modelClass = null) {

        if (!self::$instance) {
            self::$instance = new self();
        }

        if ($modelClass) {
            self::$instance->setClass($modelClass);
        }

        return self::$instance;

    }

    public function setClass($class) {

        $this->lastClass = $class;

    }

    public function define($class, $callable) {

        $this->definitions[$class] = $callable;

    }

    private function getDefinition($class) {

        return $this->definitions[$class];

    }

    /**
     * @param int $count
     * @return Collection|Model|Model[]
     * @throws \Exception
     */
    public function create($count = 1) {

        $generator = $this->getDefinition($this->lastClass);

        if ($generator == null) {
            throw new \Exception("No generator defined for class {$this->lastClass}");
        }

        $generatedModels = new Collection($this->lastClass);

        foreach (range(1, $count) as $number) {
            $data = $generator($this->fakerInstance);
            $classInstance = new $this->lastClass;
            $classInstance->fromArray($data);

            $generatedModels->add($classInstance);
        }

        if ($count == 1) {
            return $generatedModels->get(0);
        }

        return $generatedModels;

    }

    public function removeDefinition($class) {
        unset($this->definitions[$class]);
    }

    public function removeAllDefinitions() {
        $this->definitions = [];
    }

}
