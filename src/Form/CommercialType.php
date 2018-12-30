<?php

namespace App\Form;

use App\Entity\Commercial\Commercial;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommercialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('nom', TextType::class, [
                'label' => false,
            ])
            ->add('prenom', TextType::class, [
                'label' => false
            ])
            ->add('sexe', ChoiceType::class, [
                'label' => false,
                'choices'  => array(
                    'Masculin' => 'Masculin',
                    'Féminin' => 'Féminin'
                ),
            ])
            ->add('dateNaissance', TextType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('telephone', TextType::class, [
                'label' => false
            ])
            ->add('email', TextType::class, [
                'required' => false,
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commercial::class,
        ]);
    }
}
