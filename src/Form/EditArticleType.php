<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, array('label' => 'Titre', 'attr' => array('class' => 'form-control')))
                ->add('content', TextType::class, array('label' => 'contenu', 'attr' => array('class' => 'form-control')))
                ->add('photo', FileType::class, array('data_class' => null,'required'=>false, 'label' => 'Photo', 'attr' => array('class' => 'form-control')))


        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options) {

        $entity = $form->getData();
        if ($entity) {
            if ($entity->getPhoto() === NULL) {
                $path = null;
            } else {
                $path = '/uploads/articles/' . $entity->getPhoto();
            }
           
             $view->vars['file_view'] = (null === $entity->getPhoto()) ? null : '/uploads/articles/' . $entity->getPhoto();
        }
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'file_view' => null,
        ]);
    }

}
