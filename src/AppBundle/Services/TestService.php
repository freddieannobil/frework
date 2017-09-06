<?php
/**
 * Created by PhpStorm.
 * User: fredd
 * Date: 05/09/2017
 * Time: 15:15
 */

namespace AppBundle\Services;


use Symfony\Component\HttpFoundation\Response;

class TestService
{
    public function init()
    {
        return new Response('test service');
    }

}