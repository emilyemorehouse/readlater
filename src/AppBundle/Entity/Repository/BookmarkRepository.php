<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * Class BookmarkRepository
 *
 * @package AppBundle\Entity\Repository
 * @author Arkadius Stefanski <arkste@gmail.com>
 */
class BookmarkRepository extends EntityRepository
{
    public function findByUser(User $user)
    {
        $qb = $this->createQueryBuilder('b');

        $qb->select('b')
            ->where($qb->expr()->eq('b.user', ':user'))
            ->setParameter('user', $user)
            ->orderBy('b.id', 'desc');

        return $qb->getQuery();
    }

    public function findOneByUser(User $user, $id)
    {
        $qb = $this->createQueryBuilder('b');

        $qb->select('b')
            ->join('b.user', 'user')->addSelect('user')
            ->join('b.url', 'url')->addSelect('url')
            ->join('b.tags', 'tags')->addSelect('tags')
            ->where($qb->expr()->eq('b.id', ':id'))
            ->andWhere($qb->expr()->eq('user.id', ':user'))
            ->setParameters(array('id' => $id, 'user' => $user));

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function createSearchQueryBuilder($entityAlias)
    {
        $qb = $this->createQueryBuilder($entityAlias);

        $qb->select($entityAlias)
            ->join($entityAlias.'.user', 'user')->addSelect('user')
            ->join($entityAlias.'.url', 'url')->addSelect('url')
            ->join($entityAlias.'.tags', 'tags')->addSelect('tags');

        return $qb->getQuery()->setHydrationMode(Query::HYDRATE_ARRAY);
    }
}
