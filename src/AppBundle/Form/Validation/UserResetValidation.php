<?php
/**
 * Created by PhpStorm.
 * User: fredd
 * Date: 29/01/2017
 * Time: 17:34
 */

namespace AppBundle\Form\Validation;

use Symfony\Component\Validator\Constraints as Assert;

class UserResetValidation
{
    /**
     * @Assert\Email()
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

}