<?php
//
//namespace App\Form;
//
//use Symfony\Component\Form\AbstractType;
//
//class YesNoType extends AbstractType {
//
//    public function setDefaultOptions(OptionsResolverInterface $resolver) {
//        $resolver->setDefaults(array(
//            'choices' => array(0 => 'app.form.no', 1 => 'app.form.yes'),
//            'expanded' => true,
//            'empty_data' => 0,
//        ));
//    }
//
//    public function getParent() {
//        return 'choice';
//    }
//
//    public function getName() {
//        return 'yes_no';
//    }
//
//}
namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YesNoType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'choices' => array(0 => 'app.form.no', 1 => 'app.form.yes'),
            'expanded' => true,
            'empty_data' => 0,
        ));
    }

    public function getParent() {
        return 'choice';
    }

    public function getName() {
        return 'yes_no';
    }
}