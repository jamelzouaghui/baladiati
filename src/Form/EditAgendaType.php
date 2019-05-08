<?php

namespace App\Form;

use App\Entity\Agenda;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditAgendaType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, array('label' => 'Titre', 'attr' => array('class' => 'form-control')))
                ->add('adress', TextType::class, array('label' => 'Adresse', 'attr' => array('class' => 'form-control')))
                       ->add('dateCreation', DateType::class, array(
                    'label' => "date début",
                    'widget' => 'single_text',
                    'input' => 'datetime',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'attr' => array('class' => 'js-datepicker form-control'),
                        )
        );
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Agenda::class,
        ]);
    }

}
