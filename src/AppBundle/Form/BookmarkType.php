<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

/**
 * Class BookmarkType
 *
 * @package AppBundle\Form
 * @author Arkadius Stefanski <arkste@gmail.com>
 */
class BookmarkType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'label_title'))
            ->add('url', 'app_url', array('label' => 'label_url'))
            ->add('tags', 'app_tag', array('label' => 'label_tags'))
            ->add('save', 'submit', array('label' => 'label_save', 'attr' => array('class' => 'btn-success')));

        if (!is_null($options['nowindow'])) {
            $builder->add('nowindow', 'hidden', array('mapped' => false, 'data' => 1));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Bookmark',
            'attr' => array('novalidate' => 'novalidate'),
            'cascade_validation' => true,
            'nowindow' => null,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_bookmark';
    }
}
