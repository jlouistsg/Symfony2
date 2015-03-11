<?php

namespace Esgi\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Esgi\BlogBundle\Entity\Post;
use Esgi\BlogBundle\Form\ProposePostType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $em = $this->get("doctrine.orm.entity_manager");
        $publishedPosts = $em->getRepository('EsgiBlogBundle:Post')->findPublicationStatus(false);

        return $this->render('EsgiBlogBundle:Default:index.html.twig', array(
            'publishedPosts' => $publishedPosts,
        ));
    }

    /**
     * @Route("/addition/{a}/{b}")
     * @Template()
     */
    public function additionAction($a, $b)
    {
        return [
            'sum' => $this->get('esgi.computer')->addition($a, $b),
            'power' => $this->get('esgi.computer')->power($a),
        ];
    }

    /**
     * @Route("/new-post")
     * @Template()
     */
    public function newPostAction()
    {
        $post = new Post();
        $post->setTitle("test title");
        $post->setBody("test title");

        $em = $this->get("doctrine.orm.entity_manager");
        $em->persist($post);
        $em->flush();

        return new Response('le post '.$post->getId().' a bien ete cree');
    }


    /**
     * @Route("/propose", name="blog_propose")
     * @Template()
     */
    public function proposeAction(Request $request)
     {
        $post = new Post();

        $post->setIsPublished(false);

        $form=$this->createForm(new ProposePostType(), $post);

        if($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if($form->isValid()) {
                // save the proposition

                $em = $this->get("doctrine.orm.entity_manager");
                $em->persist($post);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Your proposition has been saved!');
                return $this->redirect($this->generateUrl('blog_propose'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }
}