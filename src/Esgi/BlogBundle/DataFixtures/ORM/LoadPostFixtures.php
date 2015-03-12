<?php
namespace Esgi\BlogBundle\DataFixtures;

use Esgi\BlogBundle\Entity\Post;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadPostFixtures extends AbstractFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $i = 1;
        while ($i <= 100) {
            $post = new Post();
            $post->setTitle('Titre du post n°'.$i);
            $post->setBody('Corps du post');
            $post->setIsPublished($i%2);
            $rand = rand(1, 10);
            $post->setCategory($this->getReference('category-'.$rand));
            $manager->persist($post);
            $i++;
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

    public function setSlug(ObjectManager $manager)
    {

        // get posts from db
        $publishedPosts = $manager->getRepository('EsgiBlogBundle:Post')->findPublicationStatus(false);

        foreach ($publishedPosts as $post)
        {
            $post->setSlug(slugify($post->getTitle));
            $manager->persist($post);
        }

        $manager->flush();
    }

}
