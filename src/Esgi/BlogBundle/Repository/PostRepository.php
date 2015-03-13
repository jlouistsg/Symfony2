<?php

namespace Esgi\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PostRepository extends EntityRepository
{
    public function findPublicationStatusWithLimit($status = true, $limit)
    {
        return $this->createQueryBuilder('p')
            ->where('p.isPublished = :is_published')
            ->orderBy('p.created', 'DESC')
            ->setParameter('is_published', $status)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findPublicationStatus($status = true, $page, $maxPerPage)
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.isPublished = :is_published')
            ->orderBy('p.created', 'DESC')
            ->setParameter('is_published', $status)
            ->setFirstResult(($page - 1) * $maxPerPage)
            ->setMaxResults($maxPerPage)
            ->getQuery()
            ->getResult();

        return new Paginator($query);
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

    public function getPublishedTotal($status = true)
    {
        return $this->createQueryBuilder('p')
            ->select('count(p)')
            ->where('p.isPublished = :is_published')
            ->orderBy('p.created', 'DESC')
            ->setParameter('is_published', $status)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
