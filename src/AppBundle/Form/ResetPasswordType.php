<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Form\Validation\PasswordResetValidation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', TextType::class,[
            'disabled' => true
        ])
            ->add('username', TextType::class,[
                'disabled' => true
            ])
            ->add('first_name', TextType::class,[
                'disabled' => true
            ])
            ->add('last_name', TextType::class,[
                'disabled' => true
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

}
