<?php
namespace Esgi\BlogBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'homepage'));

        // access services from the container!
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Post are just imaginary examples
        $blog = $em->getRepository('EsgiBlogBundle:Post')->findPublicationStatus(false);

        $menu->addChild('Latest Blog Post', array(
            'route' => 'admin',/*,
            'routeParameters' => array('id' => $blog->getId())*/
        ));

        // you can also add sub level's to your menu's as follows
        $menu['About Me']->addChild('Edit profile', array('route' => 'edit_profile'));

        // ... add more children

        return $menu;
    }
}
