<?php

namespace App\Form;

use App\Entity\Session;
use App\Form\ProgrammType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SessionAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateBeginSession', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('dateEndSession', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('nbMaxSession', IntegerType::class)
            
            ->add('programms', CollectionType::class, [
                //la collection attend l'élèment qu'elle entrera dans le formulaire
                //cela peut être autre chose qu'un formulaire
                'entry_type' => ProgrammType::class,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false // Obligatoire car Session n'a pas de setter pour programm, c'est Programm qui contient un setSession. C'est programm qui est proprio de relation. Evite un mapping false
            ])
            // ->add('trainer')
            // ->add('trainees')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
