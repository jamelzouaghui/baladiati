<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormViewInterface;
use Symfony\Component\Form\FormInterface;

class EditUserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('firstname', TextType::class, array('label' => 'Nom', 'attr' => array('class' => 'form-control')))
                ->add('lastname', TextType::class, array('label' => 'Prenom', 'attr' => array('class' => 'form-control')))
                ->add('email', TextType::class, array('label' => 'Email', 'attr' => array('class' => 'form-control')))
                ->add('photo', FileType::class, array('data_class' => null, 'label' => 'Photo', 'attr' => array('class' => 'form-control')))
                ->add('profession', TextType::class, array('label' => 'Profession', 'attr' => array('class' => 'form-control')))
                ->add('cv', TextType::class, array('label' => 'Cv', 'attr' => array('class' => 'form-control')))

        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    

}
