<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RegistrationFormType
 *
 * @package AppBundle\Form\Type
 * @author Arkadius Stefanski <arkste@gmail.com>
 */
class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('submit', 'submit', array('label' => 'registration.submit', 'translation_domain' => 'FOSUserBundle', 'attr' => array('class' => 'btn-success')));
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'app_registration';
    }
}
