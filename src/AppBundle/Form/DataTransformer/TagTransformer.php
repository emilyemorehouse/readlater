<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Tag;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class TagTransformer
 *
 * @package AppBundle\Form\DataTransformer
 * @author Arkadius Stefanski <arkste@gmail.com>
 */
class TagTransformer implements DataTransformerInterface
{
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function transform($tag)
    {
        if (null === $tag || !$tag instanceof Collection) {
            return "";
        }

        return join(', ', $tag->toArray());
    }

    public function reverseTransform($tagString)
    {
        $tagCollection = new ArrayCollection();

        if (empty($tagString)) {
            return $tagCollection;
        }

        $slugify = new Slugify();
        foreach (explode(',', $tagString) as $tag) {
            $tag = trim($tag);
            $tagSlugged = $slugify->slugify($tag);

            $tagEntity = $this->em
                ->getRepository('AppBundle:Tag')
                ->findOneBy(array('tag' => $tagSlugged));

            if (!$tagEntity instanceof Tag) {
                $tagEntity = new Tag();
                $tagEntity->setTag($tagSlugged);
            }

            $tagCollection->add($tagEntity);
        }

        return $tagCollection;
    }

    public function titleToTags($title)
    {
        $slugify = new Slugify();
        $stopwords = array('with', 'your', 'and', 'for', 'the', 'com', 'iii', 'fuer', 'mit', 'der', 'die', 'das', 'org', 'und', 'you', 'net', 'from');

        $tags = array_slice(array_unique(array_filter(explode(' ', $slugify->slugify($title, ' ')), function ($tag) use ($stopwords) {
            return strlen($tag) >= 3 && !in_array($tag, $stopwords);
        })), 0, 10);

        return count($tags) == 0 ? 'untagged' : implode(',', $tags);
    }
}