<?php

namespace Esgi\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function findPublicationStatus($status = true)
    {
        return $this->createQueryBuilder('p')
            ->where('p.isPublished = :is_published')
            ->orderBy('p.created', 'DESC')
            ->setParameter('is_published', $status)
            ->getQuery()
            ->getResult();
    }

    public function findPublicationSlug($slug)
    {
        return $this->createQueryBuilder('p')
            ->where('p.slug = :slug_value')
            ->setParameter('slug_value', $slug)
            ->getQuery()
            ->getResult();
    }

    public function findPublicationByCategory($category)
    {
        return $this->createQueryBuilder('p')
            ->where('p.category = :category')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }
}
