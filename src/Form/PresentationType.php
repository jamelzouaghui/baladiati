<?php

namespace App\Form;

use App\Entity\Presentation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PresentationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, array('label' => 'Titre', 'attr' => array('class' => 'form-control')))
                ->add('content', TextType::class, array('label' => 'Contenu', 'attr' => array('class' => 'form-control')))
                

        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Presentation::class,
        ]);
    }

}
