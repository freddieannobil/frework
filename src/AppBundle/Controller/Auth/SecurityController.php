<?php

namespace AppBundle\Controller\Auth;

use AppBundle\Form\LoginForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login")
     *
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class, [
            '_username'=> $lastUsername
        ]);

        return $this->render($this->getParameter('theme_name').'/auth/login.html.twig', array(
            'error'         => $error,
            'form' => $form->createView()
        ));

       // return $this->get('app.cache')->render('loginBody', $view);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('this should not be reached');

    }
}
