<?php
/**
 * Created by PhpStorm.
 * User: fredd
 * Date: 25/01/2017
 * Time: 09:31
 */

namespace AppBundle\Services;


class SweetAlerts
{

    public static function registrationVerifySuccess()
    {

        $alert = '<script> swal("Success!","An activation link has been sent to your email address for verification.","success")</script>';

        return $alert;
    }

    public static function registrationSuccess()
    {

        $alert = '<script> swal("Success!","Your account has been created.","success")</script>';

        return $alert;
    }

    public static function registrationActivationError()
    {

        $alert = '<script> swal("Oh no!","There was a problem activating your account!","error")</script>';

        return $alert;
    }

    public function registrationActivationSuccess()
    {
        $alert = '<script> swal("Success!","Your email has been verified and your account activated. Please log in","success")</script>';

        return $alert;
    }

    public function resetEmailSentSuccess()
    {
        $alert = '<script> swal("Success!","Reset link sent to your email address","success")</script>';

        return $alert;
    }

    public function resetTokenError()
    {
        $alert = '<script> swal("Invalid!","Invalid Password Reset Token.","error")</script>';

        return $alert;
    }

    public function resetPasswordSuccess()
    {
        $alert = '<script> swal("Success!","You Password has been reset. Login","success")</script>';

        return $alert;
    }

}