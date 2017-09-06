<?php
/**
 * Created by PhpStorm.
 * User: fredd
 * Date: 29/01/2017
 * Time: 15:45
 */

namespace AppBundle\Controller\Auth;


use AppBundle\Form\RecoverPasswordType;
use AppBundle\Form\ResetPasswordType;
use AppBundle\Form\UserProfileType;
use AppBundle\Form\Validation\UserResetValidation;
use AppBundle\Services\Emails;
use AppBundle\Services\RandomString;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ForgotPasswordController
 * @package AppBundle\Controller
 */
class ForgotPasswordController extends Controller
{
    /**
     * @Route("/recover", name="recover_password")
     */
    public function recoverAction(Request $request, RandomString $random_string, Emails $user_email)
    {
        $form = $this->createForm(RecoverPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $user =  $em->getRepository('AppBundle:User')->findOneBy(['email' => $data->getEmail()]);

            if(!$user){

                $this->addFlash(
                    'user_error', 'Could not find that email in the system');


                return $this->redirectToRoute('recover_password');
            }else{

               //create recover token and insert into database then send email.
                $token = $random_string->init();
                $user->setRecoverHash($token);
                $em->flush();

                $user_email->sendResetPasswordLink($user->getEmail(), 'payments@webberdoo.co.uk', $user->getFirstName(), $token);

           //     $this->addFlash(
           //         'success_reset_email_sent', 'Reset link sent to your email address');

                $request->getSession()
                    ->getFlashBag()
                    ->add('success_reset_email_sent', "Reset link sent to your email address");

                return $this->redirectToRoute('homepage');
            }

        }

        return $this->render($this->getParameter('theme_name').'/auth/recover.html.twig', [
            'form' => $form->createView() ,
        ]);

      //  return $this->get('app.cache')->render('recoverBody', $view);
    }


    /**
     * Check User account for activation
     *
     * @Route("/reset-password/{token}", name="reset_password")
     */
    public function resetPassword(Request $request, $token)
    {

        $form = $this->createForm(UserProfileType::class);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $user =  $em->getRepository('AppBundle:User')->findOneBy(['recover_hash' => $token]);

        if(!$user || $user->getRecoverHash() != $token){

         //   $this->addFlash(
          //      'reset_token_error', "Invalid Password Reset Token.");

            $request->getSession()
                ->getFlashBag()
                ->add('reset_token_error', "Invalid Password Reset Token.");

            return $this->redirectToRoute('homepage');
        }

        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encoded);
            $user->setRecoverHash(null);

            $em->flush();

        //    $this->addFlash(
          //      'success_reset_password', "Your Password has been reset. Login");

            $request->getSession()
                ->getFlashBag()
                ->add('success_reset_password', "Your Password has been reset. Login");

            return $this->redirectToRoute('security_login');
        }

        return $this->render($this->getParameter('theme_name').'/auth/reset.html.twig', [
            'form' => $form->createView() ,
        ]);

       // return $this->get('app.cache')->render('resetPasswordBody', $view);

    }

}