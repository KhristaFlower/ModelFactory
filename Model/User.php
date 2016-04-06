<?php

namespace Model;

use App\Record;

/**
 * Created by PhpStorm.
 * User: Kriptonic
 * Date: 06/04/2016
 * Time: 22:24
 */
class User extends Record
{

    public $username;
    public $email;
    public $password;
    public $date_of_birth;
    public $country_code;

    /** @var \App\Collection|\Model\Post[] */
    public $posts;

}
