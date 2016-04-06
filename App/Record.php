<?php

namespace App;

/**
 * Created by PhpStorm.
 * User: Kriptonic
 * Date: 06/04/2016
 * Time: 22:24
 */
abstract class Record
{

    public function fromArray($data) {

        foreach ($data as $property => $value) {

            $this->$property = $value;

        }

        return $this;

    }

}
