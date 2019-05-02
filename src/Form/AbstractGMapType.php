<?php

namespace App\Form;

use App\Entity\AbstractGMap;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class AbstractGMapType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('commentaire', CKEditorType::class, array(
                    'label' => 'Commentaire',
                    'config' => array(
                        'uiColor' => '#999999',
                    ),
                ))
                ->add('publicated', ChoiceType::class, [
                    'label' => 'Publication : ',
                    'attr' => array('class' => 'form-control'),
                    'choices' => ['Publié' => true, "n'est pas publié" => false],
                ])
              
                 ->add('etat', ChoiceType::class, [
                    'label' => 'Etat de reclamation : ',
                    'attr' => array('class' => 'form-control'),
                    'choices' => ['En Cours' => false, "Traité" => true],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => AbstractGMap::class,
        ]);
    }

}
