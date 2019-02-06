<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('firstname', TextType::class, array('label' => 'Nom', 'attr' => array('class' => 'form-control')))
                ->add('lastname', TextType::class, array('label' => 'Prenom', 'attr' => array('class' => 'form-control')))
                ->add('email', TextType::class, array('label' => 'Email', 'attr' => array('class' => 'form-control')))
                ->add('photo', FileType::class, array('label' => 'Photo', 'attr' => array('required'=>false,'class' => 'form-control')))
                ->add('profession', TextType::class, array('label' => 'Profession', 'attr' => array('class' => 'form-control')))
                ->add('cv', TextareaType::class, array('label' => 'Cv', 'attr' => array('class' => 'form-control')))
                ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => array('label' => 'Password','attr' => array('class' => 'form-control')),
                    'second_options' => array('label' => 'Repeat Password','attr' => array('class' => 'form-control')),
                ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}
