<?php

namespace App\Form\Commercial;

use App\Entity\Commercial\Commercial;
use App\Entity\Commercial\ProspectingSheet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProspectingSheetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', TextType::class, [
                'label' => false
            ])
            ->add('commercial', EntityType::class, [
                'class' => Commercial::class,
                'choice_label' => 'code',
                'label' => false

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProspectingSheet::class,
        ]);
    }
}
