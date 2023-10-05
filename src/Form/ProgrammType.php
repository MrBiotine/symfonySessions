<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Programm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProgrammType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('course', EntityType::class, [
                'label' => 'Module',
                'class' => Course::class,
                'choice_label' => 'nameCourse'

            ])
            // ->add('session', HiddenType::class)
            ->add('nbDay', IntegerType::class, [
                'label' => 'Durée en jours',
                'attr' => ['min' => '1', 'max' => '100'],
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programm::class,
        ]);
    }
}
