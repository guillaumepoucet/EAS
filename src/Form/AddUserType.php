<?php

namespace App\Form;

use DateTime;
use App\Entity\User;
use App\Entity\Course;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class AddUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            // ->add('roles')
            ->add('password', PasswordType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('last_name')
            ->add('first_name')
            // ->add('birth_date')
            // ->add('isVerified')
            ->add('sessions', EntityType::class, [
                'class' => Session::class,
                'choice_label' => function ($course) {
                    return $course->getCourse()->getCourseName() . ', du ' . $course->getStartDate()->format('d/m/Y') . ' au ' . $course->getEndDate()->format('d/m/Y');
                },
                'multiple' => true,
                'expanded' => true,

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'forms'
        ]);
    }
}
