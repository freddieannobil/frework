<?php
/**
 * Created by PhpStorm.
 * User: fredd
 * Date: 29/01/2017
 * Time: 17:34
 */

namespace AppBundle\Form\Validation;

use Symfony\Component\Validator\Constraints as Assert;

class SubscribeValidation
{
    /**
     *
     */
  //  private $first_name;

    /**
     * @Assert\Email()
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @return mixed
     */
 /*   public function getFirstName()
    {
        return $this->first_name;
    }*/

    /**
     * @param mixed $first_name
     */
  /*  public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }*/

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