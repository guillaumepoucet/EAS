<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Course;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start_date')
            ->add('end_date')
            // ->add('user', EntityType::class, [
            //     'class' => User::class
            //     ])
                
            ->add('course', EntityType::class, [
                'class' => Course::class,
                'choice_label' => function ($course) {
                    return $course->getCourseName();
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
