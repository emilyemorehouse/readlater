<?php

namespace AppBundle\Controller;

use FOS\ElasticaBundle\Paginator\RawPaginatorAdapter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 *
 * @package AppBundle\Controller
 * @author Arkadius Stefanski <arkste@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, $tags = null)
    {
        $searchRepo = $this->get('fos_elastica.manager')->getRepository('AppBundle:Bookmark');
        $searchIndex = $this->get('fos_elastica.index.readlater.bookmarks');

        $bookmarks = new RawPaginatorAdapter($searchIndex, $searchRepo->findByUserAndTags($this->getUser(), $tags));

        $pagination = $this->get('knp_paginator')
            ->paginate(
                $bookmarks,
                $request->query->get('page', 1),
                50,
                array('sortFieldWhitelist' => array('id', 'title', 'url.url'))
            );

        return $this->render('Default/index.html.twig', array(
            'bookmarks' => $pagination,
            'tagcloud' => $bookmarks->getAggregations(),
        ));
    }

    /**
     * @Route("/tag/{tags}", name="bookmark_tag")
     */
    public function tagAction(Request $request, $tags)
    {
        return $this->indexAction($request, $tags);
    }
}