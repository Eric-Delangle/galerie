<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Purchase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CartConfirmationType extends AbstractType
{

    protected $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $user = $this->security->getUser();
        // dd($user);
        if ($user) {

            $builder
                ->add('fullName', TextType::class, [
                    'label' => 'Nom complet',
                    'attr' => [
                        'placeholder' => 'Quel nom donner à cette commande ?'

                    ]
                ])
                ->add('address', TextareaType::class, [
                    'label' => 'Adresse complète',
                    'attr' => [
                        'placeholder' => 'Adresse complète pour la livraison'
                    ]
                ])
                ->add('postalCode', TextType::class, [
                    'label' => 'Code Postal',
                    'attr' => [
                        'placeholder' => 'Code postal pour la livraison'
                    ]
                ])
                ->add('city', TextType::class, [
                    'label' => 'Ville',
                    'attr' => [
                        'placeholder' => 'Ville pour la livraison'
                    ]
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Purchase::class
        ]);
    }
}
