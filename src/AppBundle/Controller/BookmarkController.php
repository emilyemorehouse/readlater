<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bookmark;
use AppBundle\Entity\Url;
use AppBundle\Form\DataTransformer\TagTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints;

/**
 * Class DefaultController
 *
 * @package AppBundle\Controller
 * @author Arkadius Stefanski <arkste@gmail.com>
 *
 * @Route("/bookmark")
 */
class BookmarkController extends Controller
{
    /**
     * @Route("/add", name="bookmark_add")
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $bookmark = new Bookmark();
        $bookmark->setUser($this->getUser());

        // Url-Parameter
        $urlParameter = $request->get('url', null);
        $titleParameter = $request->get('title', null);
        if (!is_null($urlParameter)) {
            $url = new Url();
            $url->setUrl($urlParameter);

            $bookmark->setUrl($url);

            $validator = $this->get('validator');
            $errors = $validator->validateValue($urlParameter, new Constraints\Url());

            if ($errors->count() != 0) {
                foreach ($errors as $error) {
                    $this->addFlash('danger', $error);
                }
            } else {
                $tagTransformer = new TagTransformer($em);
                $bookmark->setTitle($titleParameter);
                $url->setUrl($urlParameter);
                $tags = $tagTransformer->reverseTransform($tagTransformer->titleToTags($titleParameter));
                if (count($tags) != 0) {
                    foreach ($tags as $tag) {
                        $bookmark->addTag($tag);
                    }
                }
            }
        }

        $bookmarkForm = $this->createForm('app_bookmark', $bookmark, array('action' => $this->generateUrl('bookmark_add', array('nowindow' => $request->get('nowindow', null))), 'nowindow' => $request->get('nowindow', null)))->handleRequest($request);

        if ($bookmarkForm->isValid()) {
            $em->persist($bookmark);
            $em->flush();

            if ($bookmarkForm->has('nowindow') && !is_null($bookmarkForm->get('nowindow')->getData())) {
                return new Response('<script>window.close();</script>');
            }

            $this->addFlash('success', 'flashbag_bookmark_add_success');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('Default/add.html.twig', array(
            'bookmarkForm' => $bookmarkForm->createView(),
        ));
    }

    /**
     * @Route("/edit/{id}", name="bookmark_edit")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $bookmark = $em->getRepository('AppBundle:Bookmark')->findOneByUser($this->getUser(), $id);
        if (!$bookmark instanceof Bookmark) {
            throw new NotFoundHttpException();
        }

        $bookmarkForm = $this->createForm('app_bookmark', $bookmark)->handleRequest($request);

        if ($bookmarkForm->isValid()) {
            $em->persist($bookmark);
            $em->flush();

            $this->addFlash('success', 'flashbag_bookmark_edit_success');

            return $this->redirect($request->headers->get('referer', $this->generateUrl('homepage')));
        }

        return $this->render('Default/add.html.twig', array(
            'bookmarkForm' => $bookmarkForm->createView(),
        ));
    }

    /**
     * @Route("/delete/{id}", name="bookmark_delete")
     */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $bookmark = $em->getRepository('AppBundle:Bookmark')->findOneByUser($this->getUser(), $id);
        if (!$bookmark instanceof Bookmark) {
            throw new NotFoundHttpException();
        }

        $em->remove($bookmark);
        $em->flush();

        $this->addFlash('success', 'flashbag_bookmark_delete_success');

        return $this->redirect($request->headers->get('referer', $this->generateUrl('homepage')));
    }
}