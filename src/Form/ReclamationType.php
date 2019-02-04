<?php

namespace App\Form;

use App\Entity\AbstractGMap;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adress', TextType::class, array('label' => 'Adresse', 'attr' => array('class' => 'form-control')))
            ->add('name', TextType::class, array('label' => 'Name', 'attr' => array('class' => 'form-control')))
            ->add('city')
            ->add('latitude')
            ->add('longitude')
            ->add('createdAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AbstractGMap::class,
        ]);
    }
}
