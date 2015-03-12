<?php

namespace Esgi\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Esgi\BlogBundle\Entity\Post;
use Esgi\BlogBundle\Form\ProposePostType;
use Esgi\BlogBundle\Entity\Comment;
use Esgi\BlogBundle\Form\ProposeCommentType;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
    /**
     * @Route("/" , name="blog_get_articles")
     * @Template()
     */
    public function getPostsAction()
    {
        // init connection to db
        $em = $this->get("doctrine.orm.entity_manager");

        // get posts from db
        $publishedPosts = $em->getRepository('EsgiBlogBundle:Post')->findPublicationStatus(true);

        // get categories from db
        $categories = $em->getRepository('EsgiBlogBundle:Category')->getCategory();

        // return posts to view
        return array('publishedPosts' => $publishedPosts,'categories' => $categories);
    }

    /**
     * @Route("/article/get/{slug}" , name="blog_get_article")
     * @Template()
     */
    public function getPostAction($slug, Request $request)
    {
        // init connection to db
        $em = $this->get("doctrine.orm.entity_manager");

        // get the post by slug
        $publishedPost = $em->getRepository('EsgiBlogBundle:Post')->findPublicationSlug($slug);

        // get the comments
        $publishedComments = $em->getRepository('EsgiBlogBundle:Comment')->findCommentPublicationStatus(true, $publishedPost[0]);

        // create a comment
        $comment = new Comment();
        $comment->setIsPublished(false);
        $comment->setPost($publishedPost[0]);

        // init the form
        $form = $this->createForm(new ProposeCommentType(), $comment);

        // save the comment
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->get("doctrine.orm.entity_manager");
                $em->persist($comment);
                $em->flush();

                // return msg to the view
                $this->get('session')->getFlashBag()->add('success', 'Your proposition has been saved!');

                return $this->redirect($this->generateUrl('blog_get_article', array('slug' => $slug)));
            }
        }

        // return to the view the argument
        return array(
            'form' => $form->createView(),
            'publishedPost' => $publishedPost,
            'publishedComments' => $publishedComments,
        );
    }

    /**
     * @Route("/article/edit/{slug}", name="blog_edit_article")
     * @Template()
     */
    public function editPostAction($slug, Request $request)
    {

       // init connection to db
        $em = $this->get("doctrine.orm.entity_manager");

        // get the post by slug
        $publishedPost = $em->getRepository('EsgiBlogBundle:Post')->findPublicationSlug($slug);

        // init form with object post
        $form = $this->createForm(new ProposePostType(), $publishedPost[0]);

        // if the post is send
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            // if the form is valid
            if ($form->isValid()) {
                $em = $this->get("doctrine.orm.entity_manager");
                $em->persist($publishedPost[0]);
                $em->flush();

                // return msg to the page
                $this->get('session')->getFlashBag()->add('success', 'Your post has been saved!');

                return $this->redirect($this->generateUrl('blog_edit_article', array('slug' => $slug)));
            }
        }

        // return the form
        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/article/propose", name="blog_propose_article")
     * @Template()
     */
    public function proposePostAction(Request $request)
    {
        // define new post
        $post = new Post();

        // set isPublished at false
        $post->setIsPublished(false);

        // init form with object post
        $form = $this->createForm(new ProposePostType(), $post);

        // if the post is send
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            // if the form is valid
            if ($form->isValid()) {
                $em = $this->get("doctrine.orm.entity_manager");
                $em->persist($post);
                $em->flush();

                // return msg to the page
                $this->get('session')->getFlashBag()->add('success', 'Your post has been saved!');

                return $this->redirect($this->generateUrl('blog_propose_article'));
            }
        }

        // return the form
        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/article/new")
     * @Template()
     */
    public function newPostAction(Request $request)
    {
        // define new post
        $post = new Post();

        // set isPublished at false
        $post->setIsPublished(false);

        // init form with object post
        $form = $this->createForm(new ProposePostType(), $post);

        // if the post is send
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            // if the form is valid
            if ($form->isValid()) {
                $em = $this->get("doctrine.orm.entity_manager");
                $em->persist($post);
                $em->flush();

                // return msg to the page
                $this->get('session')->getFlashBag()->add('success', 'Your post has been saved!');

                return $this->redirect($this->generateUrl('blog_get_articles'));
            }
        }

        // return the form
        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/article/delete/{slug}")
     * @Template()
     */
    public function deletePostAction($slug)
    {
        // init connection to db
        $em = $this->get("doctrine.orm.entity_manager");

        // get the post by slug
        $publishedPost = $em->getRepository('EsgiBlogBundle:Post')->findPublicationSlug($slug);

        // if the post is not empty or null
        if ($publishedPost != null) {

            // get all comments of the post
            $publishedComments = $em->getRepository('EsgiBlogBundle:Comment')->findCommentPublication($publishedPost[0]);

            // if comments is not empty or null
            if ($publishedComments != null) {

                // remove all comments
                foreach ($publishedComments as $comment) {
                    $em->remove($comment);
                }

                // remove the post
                $em->remove($publishedPost[0]);

                // save the change
                $em->flush();

                return new $this->redirect($this->generateUrl('blog_get_articles'));
            }
        } else {
            return $this->render('EsgiBlogBundle:Error:Error.html.twig', array());
        }
    }

    /**
     * @Route("/article/category/{category_name}")
     * @Template()
     */
    public function getPostByCategoryAction($category_name)
    {
        // init connection to db
        $em = $this->get("doctrine.orm.entity_manager");

        // get posts from db
        $category = $em->getRepository('EsgiBlogBundle:Category')->findCategoryByName($category_name);

        if ($category != null) {
            $publishedPosts = $em->getRepository('EsgiBlogBundle:Post')->findPublicationByCategory($category[0]);

            if ($publishedPosts != null) {
                // return posts to view
                return $this->render('EsgiBlogBundle:Post:getPosts.html.twig', array(
                    'publishedPosts' => $publishedPosts,
                ));
            } else {
                // return posts to view
                return $this->render('EsgiBlogBundle:Error:Error.html.twig', array('msgError' => 'pas de post'));
            }
        } else {
            // return posts to view
            return $this->render('EsgiBlogBundle:Error:Error.html.twig', array('msgError' => 'pas de category'));
        }
    }
}
