<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Bookmark;
use AppBundle\Entity\User;
use AppBundle\Form\DataTransformer\TagTransformer;
use AppBundle\Form\DataTransformer\UrlTransformer;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadDefaultData
 *
 * @package AppBundle\DataFixtures\ORM
 * @author Arkadius Stefanski <arkste@gmail.com>
 */
class LoadDefaultData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setUsername('demo')
            ->setEmail('demo@localhost')
            ->setPlainPassword('demo')
            ->setEnabled(true);
        $manager->persist($user);

        $tagTransformer = new TagTransformer($manager);
        $urlTransformer = new UrlTransformer($manager);

        $bookmark = new Bookmark();
        $bookmark
            ->setUser($user)
            ->setTitle('GitHub')
            ->setUrl($urlTransformer->reverseTransform('https://github.com'))
            ->addTag($tagTransformer->reverseTransform('github')[0]);
        $manager->persist($bookmark);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}