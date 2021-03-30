<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('email', TextType::class, [
                'label' => "Email"
            ])
            ->add('adress')
            ->add('code_postal')
            ->add('location')
            ->add('tel')
            ->add('firstName', TextType::class, [
                'label' => "Prénom"
            ])
            ->add('lastName', TextType::class, [
                'label' => "Nom"
            ])


            ->add('password', PasswordType::class, [
                'attr' => [
                    'required' => false,

                ]
            ])
            ->add('password_verify', PasswordType::class, [
                'attr' => [
                    'required' => false,

                ]
            ])

            ->add("Enregistrer", SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'forms'
        ]);
    }
}
