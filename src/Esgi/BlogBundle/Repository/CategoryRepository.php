<?php

namespace Esgi\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function findCategory()
    {
        return $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult();
    }
}