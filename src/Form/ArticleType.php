<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, array('label' => 'Titre', 'attr' => array('class' => 'form-control')))
                ->add('content', TextType::class, array('label' => 'contenu', 'attr' => array('class' => 'form-control')))
                ->add('photo', FileType::class, array('label' => 'Photo', 'attr' => array('class' => 'form-control')))
                ->add('createdAt', TextType::class, array( 'label' => 'date de creation', 'attr' => array('class' => 'datepicker form-control')))

        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

}
