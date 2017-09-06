<?php
/**
 * Created by PhpStorm.
 * User: fredd
 * Date: 04/09/2017
 * Time: 13:14
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AppController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $name ='freddie annobil fg';

        return $this->render('default/index.html.twig', compact('name'));
    }

}