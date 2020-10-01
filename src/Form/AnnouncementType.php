<?php

namespace App\Form;

use App\Entity\Announcement;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AnnouncementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('announcement_title')
            ->add('announcement_content', CKEditorType::class, [
                'config_name' => 'announcement_config'
            ])
            ->add('is_draft', CheckboxType::class, [
                'label' => 'Enregistrer comme brouillon',
                'required' => false,
            ])
            ->add('announcement_date', DateType::class, [
                'days' => range(date('d'), 31),
                'months' => range(date('m'), 12),
                'years' => range(date('Y'), date('Y')+100),
            ])
            // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Announcement::class,
            'translation_domain' => 'forms'
        ]);
    }
}
