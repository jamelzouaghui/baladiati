<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, array('label' => 'Titre', 'attr' => array('class' => 'form-control')))
                ->add('content', CKEditorType::class, array(
                    'config' => array(
                        'uiColor' => '#999999',
                    ),
                ))
               ->add('photos', FileType::class, array('mapped'=>false,'multiple'=>true,'label' => 'Photo', 'required' => false, 'attr' => array('multiple'=>'multiple','class' => 'form-control','id' => 'add-file')))


        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

}
