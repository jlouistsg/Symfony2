<?php

namespace Esgi\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
    public function findPublicationStatus($status = true, $post)
    {
        return $this->createQueryBuilder('p')
            ->where('p.isPublished = :is_published')
            ->andWhere('p.post = :post')
            ->orderBy('p.created', 'DESC')
            ->setParameter('is_published', $status)
            ->setParameter('post', $post)
            ->getQuery()
            ->getResult();
    }
}

