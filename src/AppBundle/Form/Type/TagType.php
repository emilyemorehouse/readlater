<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\DataTransformer\TagTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class TagType
 *
 * @package AppBundle\Form\Type
 * @author Arkadius Stefanski <arkste@gmail.com>
 */
class TagType extends AbstractType
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
        $builder->addModelTransformer(new TagTransformer($this->em));
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
        return 'app_tag';
    }
}
