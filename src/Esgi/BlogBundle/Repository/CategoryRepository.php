<?php

namespace Esgi\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function findCategoryByName($name)
    {
        return $this->createQueryBuilder('p')
            ->where('p.name = :name')
            ->orderBy('p.name', 'DESC')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }

}
