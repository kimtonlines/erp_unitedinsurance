<?php

namespace App\Form\Commercial;

use App\Entity\Commercial\Township;
use App\Entity\Commercial\Ward;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('township', EntityType::class, [
                'class' => Township::class,
                'choice_label' => 'name',
                'label' => false

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ward::class,
        ]);
    }
}
