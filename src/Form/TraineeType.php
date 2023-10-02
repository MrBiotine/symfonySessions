<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Trainee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class TraineeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstNameTrainee', TextType::class)
            ->add('lastNameTrainee', TextType::class)
            ->add('emailTrainee', EmailType::class)
            ->add('genderTrainee', TextType::class, [
                'required' => false
            ])
            ->add('cityTrainee', TextType::class, [
                'required' => false
            ])
            ->add('phoneTrainee', TelType::class, [
                'required' => false
            ])
            ->add('birthDateTrainee', DateType::class, [
                'widget' => 'single_text'
            ])
            // ->add('sessions', EntityType::class, [
                // 'class' => Session::class,
                // 'choice_label' => 'id'
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trainee::class,
        ]);
    }
}
