<?php

namespace AppBundle\Entity\SearchRepository;

use AppBundle\Entity\User;
use Elastica\Aggregation;
use Elastica\Filter;
use Elastica\Query;
use FOS\ElasticaBundle\Repository;

/**
 * Class BookmarkRepository
 *
 * @package AppBundle\Entity\SearchRepository
 * @author Arkadius Stefanski <arkste@gmail.com>
 */
class BookmarkRepository extends Repository
{
    public function findByUserAndTags(User $user, $tags = null)
    {
        $filterQuery = new Query\Filtered();
        $searchFilter = new Filter\Bool();

        $searchFilter->addMust(new Filter\Term(array('user' => $user->getId())));

        if (!empty($tags)) {
            $tagFilter = new Filter\Terms('tags', explode('+', $tags));
            $tagFilter->setExecution('and');
            $searchFilter->addMust($tagFilter);
        }

        $filterQuery->setFilter($searchFilter);

        $searchQuery = new Query($filterQuery);
        $searchQuery->addSort(array('createdAt' => 'desc'));

        $agg = new Aggregation\Terms('tags');
        $agg->setField('tags')->setOrder('_count', 'desc')->setSize(100);
        $searchQuery->addAggregation($agg);

        return $searchQuery;
    }
}