<?php

namespace App\Form\Commercial;

use App\Entity\Commercial\Prospect;
use App\Entity\Commercial\ProspectingSheet;
use App\Entity\Commercial\TypeContract;
use App\Entity\Commercial\TypeProspection;
use App\Entity\Commercial\Ward;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProspectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('name', TextType::class, [
                'label' => false,
            ])
            ->add('phone', TextType::class, [
                'label' => false
            ])
            ->add('localization', TextType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('observation', TextareaType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('email', TextType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('prospectingSheet', EntityType::class, [
                'class' => ProspectingSheet::class,
                'choice_label' => 'code',
                'label' => false
            ])
            ->add('prospectingType', EntityType::class, [
                'class' => TypeProspection::class,
                'choice_label' => 'nom',
                'label' => false
            ])
            ->add('typeContract', EntityType::class, [
                'class' => TypeContract::class,
                'choice_label' => 'name',
                'label' => false
            ])
            ->add('ward', EntityType::class, [
                'class' => Ward::class,
                'choice_label' => 'name',
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prospect::class,
        ]);
    }
}
