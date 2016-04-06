<?php

namespace Model;

use App\Record;

/**
 * Created by PhpStorm.
 * User: Kriptonic
 * Date: 06/04/2016
 * Time: 22:25
 */
class Post extends Record
{

    public $title;
    public $content;
    public $posted_at;
    public $poster_id;

}
