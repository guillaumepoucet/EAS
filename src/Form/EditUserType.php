<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            // ->add('roles', ChoiceType::class, [
            //     'choice_label' => 'Admin',
            //     // 'choices' =>User::ROLE,
            
            // ])
            // ->add('password', PasswordType::class)
            ->add('last_name')
            ->add('first_name')
            ->add('birth_date')
            // ->add('isVerified')
            // ->add('sessions', EntityType::class, [
            //     'class' => Session::class,
            //     'choice_label' => function ($course) {
            //         return $course->getCourse()->getCourseName();
            //     },
            //     'multiple' => true,
            //     'expanded' => true,
            // ])
 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'forms'
        ]);
    }
}
