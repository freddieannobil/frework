<?php
/**
 * Created by PhpStorm.
 * User: fredd
 * Date: 29/01/2017
 * Time: 17:34
 */

namespace AppBundle\Form\Validation;

use Symfony\Component\Validator\Constraints as Assert;

class PasswordResetValidation
{
    /**
     * @Assert\NotBlank
     */
    private $plainPassword;

    /**
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }



}