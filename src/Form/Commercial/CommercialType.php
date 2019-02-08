<?php

namespace App\Form\Commercial;

use App\Entity\Commercial\Commercial;
use App\Entity\Commercial\Status;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Commercial\Agency;

class CommercialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('agency', EntityType::class, [
                'class' => Agency::class,
                'choice_label' => 'name',
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
            ->add('domicile', TextType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('email', TextType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('salaried', ChoiceType::class, [
                'choices' => [
                    'Non' => false,
                    'Oui' => true,
                ],
                'label' => false
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'name',
                'label' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                }

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
