<?php

namespace App\Form;

use App\Entity\Depute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditDeputeType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('firstname', TextType::class, array('label' => 'Nom', 'attr' => array('class' => 'form-control')))
                ->add('lastname', TextType::class, array('label' => 'Prenom', 'attr' => array('class' => 'form-control')))
               ->add('photo', FileType::class, array('data_class' => null,'required'=>false, 'label' => 'Photo', 'attr' => array('class' => 'form-control')))
                ->add('fonction', TextType::class, array('label' => 'Profession', 'attr' => array('class' => 'form-control')))
                ->add('cv', FileType::class, array('data_class' => null,'required'=>false, 'label' => 'Photo', 'attr' => array('class' => 'form-control')))

        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Depute::class,
        ]);
    }

    

}
