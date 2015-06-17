<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Url;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class UrlTransformer
 *
 * @package AppBundle\Form\DataTransformer
 * @author Arkadius Stefanski <arkste@gmail.com>
 */
class UrlTransformer implements DataTransformerInterface
{
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function transform($url)
    {
        if (null === $url || !$url instanceof Url) {
            return "";
        }

        return $url->getUrl();
    }

    public function reverseTransform($urlString)
    {
        if (!$urlString) {
            return null;
        }

        $url = $this->em
            ->getRepository('AppBundle:Url')
            ->findOneBy(array('urlKey' => md5($urlString)));

        if (!$url instanceof Url) {
            $url = new Url();
            $url->setUrl($urlString);
        }

        return $url;
    }
}