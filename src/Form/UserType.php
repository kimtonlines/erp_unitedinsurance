<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'label' => false
            ])
//            ->add('roles')
            ->add('password', PasswordType::class, [
                'label' => false
            ])
            ->add('confirm_password', PasswordType::class, [
                'label' => false
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('name', TextType::class, [
                'label' => false,
            ])
            ->add('phone', TextType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('permission', ChoiceType::class, [
                'label' => false,
                'choices'  => array(
                    'Utilisateur' => 'Utilisateur',
                    'Administrateur' => 'Administrateur'
                ),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
