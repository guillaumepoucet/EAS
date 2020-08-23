<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Course;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class AddUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            // ->add('roles')
            ->add('password', PasswordType::class)
            ->add('last_name')
            ->add('first_name')
            // ->add('birth_date')
            // ->add('isVerified')
            ->add('sessions', EntityType::class, [
                'class' => Session::class,
                'choice_label' => function ($course) {
                    return $course->getCourse()->getCourseName();
                },
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('Submit', SubmitType::class)
 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
