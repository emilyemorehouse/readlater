<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class PasswordResettingFormType
 *
 * @package AppBundle\Form\Type
 * @author Arkadius Stefanski <arkste@gmail.com>
 */
class PasswordResettingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('submit', 'submit', array('label' => 'resetting.reset.submit', 'translation_domain' => 'FOSUserBundle', 'attr' => array('class' => 'btn-success')));
    }

    public function getParent()
    {
        return 'fos_user_resetting';
    }

    public function getName()
    {
        return 'app_resetting';
    }
}
