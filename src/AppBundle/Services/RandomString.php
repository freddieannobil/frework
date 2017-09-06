<?php
/**
 * Created by PhpStorm.
 * User: fredd
 * Date: 25/01/2017
 * Time: 01:43
 */

namespace AppBundle\Services;


class RandomString
{

    public function init()
    {

        return md5(time() . rand());
    }

}