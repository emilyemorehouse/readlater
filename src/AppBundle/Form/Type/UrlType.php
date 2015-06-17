<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\DataTransformer\UrlTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class UrlType
 *
 * @package AppBundle\Form\Type
 * @author Arkadius Stefanski <arkste@gmail.com>
 */
class UrlType extends AbstractType
{
    private $em;

    public function __construct(ObjectManager $objectManager)
    {
        $this->em = $objectManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new UrlTransformer($this->em));
    }

    public function getParent()
    {
        return 'text';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_url';
    }
}
