<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Application\Entity\Post;

/**
 * This is the custom repository class for Post entity.
 */
class PostRepository extends EntityRepository
{
    /**
     * Retrieves all published posts in descending date order.
     * @return Query
     */
    public function findPublishedPosts()
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Post::class, 'p')
            ->where('p.status = ?1')
            ->orderBy('p.dateCreated', 'DESC')
            ->setParameter('1', Post::STATUS_PUBLISHED);

        return $queryBuilder->getQuery();
    }

    /**
     * Retrieves latest published posts in descending date order.
     * @param integer $limit
     * @return Query
     */
    public function findLatestPosts($limit = 1)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Post::class, 'p')
            ->where('p.status = ?1')
            ->orderBy('p.dateCreated', 'DESC')
            ->setMaxResults($limit)
            ->setParameter('1', Post::STATUS_PUBLISHED);

        $result = $queryBuilder->getQuery()->getResult();

        return $result;
    }

    /**
     * Retrieves countries list
     * @return Query
     */
    public function getCountries()
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p.cuisineCountry')
            ->from(Post::class, 'p')
            ->where('p.status = ?1')
            ->orderBy('p.dateCreated', 'DESC')
            ->setParameter('1', Post::STATUS_PUBLISHED)
            ->distinct();

        $result = $queryBuilder->getQuery()->getResult();

        return $result;
    }

    /**
     * Retrieves cuisine type list
     * @return Query
     */
    public function getCuisineTypes()
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p.cuisineType')
            ->from(Post::class, 'p')
            ->where('p.status = ?1')
            ->orderBy('p.dateCreated', 'DESC')
            ->setParameter('1', Post::STATUS_PUBLISHED)
            ->distinct();

        $result = $queryBuilder->getQuery()->getResult();

        return $result;
    }

    /**
     * Finds all published posts having any tag.
     * @return array
     */
    public function findPostsHavingAnyTag()
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Post::class, 'p')
            ->join('p.tags', 't')
            ->where('p.status = ?1')
            ->orderBy('p.dateCreated', 'DESC')
            ->setParameter('1', Post::STATUS_PUBLISHED);

        $posts = $queryBuilder->getQuery()->getResult();

        return $posts;
    }

    /**
     * Finds all published posts having the given tag.
     * @param string $tagName Name of the tag.
     * @return Query
     */
    public function findPostsByTag($tagName)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Post::class, 'p')
            ->join('p.tags', 't')
            ->where('p.status = ?1')
            ->andWhere('t.name = ?2')
            ->orderBy('p.dateCreated', 'DESC')
            ->setParameter('1', Post::STATUS_PUBLISHED)
            ->setParameter('2', $tagName);

        return $queryBuilder->getQuery();
    }

    /**
     * Finds all published posts having the given country.
     * @param string $cuisineCountry Name of the country.
     * @return Query
     */
    public function findPostsByCountry($cuisineCountry)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Post::class, 'p')
            ->where('p.status = ?1')
            ->andWhere('p.cuisineCountry = ?2')
            ->orderBy('p.dateCreated', 'DESC')
            ->setParameter('1', Post::STATUS_PUBLISHED)
            ->setParameter('2', $cuisineCountry);

        return $queryBuilder->getQuery();
    }

    /**
     * Finds all published posts having the given cuisine type.
     * @param string $cuisineType Name of the type.
     * @return Query
     */
    public function findPostsByCuisineType($cuisineType)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Post::class, 'p')
            ->where('p.status = ?1')
            ->andWhere('p.cuisineType = ?2')
            ->orderBy('p.dateCreated', 'DESC')
            ->setParameter('1', Post::STATUS_PUBLISHED)
            ->setParameter('2', $cuisineType);

        return $queryBuilder->getQuery();
    }

    /**
     * Finds all published posts having the given string.
     * @param string $searchQuery
     * @return Query
     */
    public function findPostsBySearchQuery($searchQuery)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(Post::class, 'p')
            ->where('p.status = ?1')
            ->andWhere('p.title LIKE %?2% OR p.description LIKE %?2% OR p.shortDescription LIKE %?2% OR p.city LIKE %?2% OR p.originalTitle LIKE %?2% OR p.cuisineType LIKE %?2% OR p.cuisineCountry LIKE %?2%')
            ->orderBy('p.dateCreated', 'DESC')
            ->setParameter('1', Post::STATUS_PUBLISHED)
            ->setParameter('2', $searchQuery);

        return $queryBuilder->getQuery();
    }
}