<?php

namespace Application\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Application\Entity\Post;
use Application\Entity\Comment;
use Application\Entity\Tag;
use Zend\Filter\StaticFilter;

/**
 * The PostManager service is responsible for adding new posts, updating existing
 * posts, adding tags to post, etc.
 */
class PostManager
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager;
     */
    private $entityManager;

    /**
     * Constructor.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * This method adds a new post.
     */
    public function addNewPost($data)
    {
        // Create new Post entity.
        $post = new Post();
        $post->setTitle($data['title']);
        $post->setOriginalTitle($data['original_title']);
        $post->setDescription($data['description']);
        $post->setShortDescription($data['short_description']);
        $post->setVideoSrc($data['video_src']);
        $post->setCuisineCountry($data['cuisine_country']);
        $post->setCuisineType($data['cuisine_type']);
        $post->setRecommendedRestaurant($data['recommended_restaurant']);
        $post->setRestaurantStreet($data['restaurant_street']);
        $post->setCity($data['city']);
        $post->setStatus($data['status']);
        $currentDate = date('Y-m-d H:i:s');
        $post->setDateCreated($currentDate);
        $post->setViews(0);

        /* Upload image */
        if ($_FILES && $_FILES['image']) {
            $image = $_FILES['image'];
            if ($image['error'] == 0) {
                move_uploaded_file($image['tmp_name'], "public/img/uploads/" . $image['name']);
                $post->setImage("/img/uploads/" . $image['name']);
            }
        }

        // Add the entity to entity manager.
        $this->entityManager->persist($post);

        // Add tags to post
        $this->addTagsToPost($data['tags'], $post);

        // Apply changes to database.
        $this->entityManager->flush();
    }

    /**
     * This method allows to update data of a single post.
     */
    public function updatePost($post, $data)
    {
        $post->setTitle($data['title']);
        $post->setOriginalTitle($data['original_title']);
        $post->setDescription($data['description']);
        $post->setShortDescription($data['short_description']);
        $post->setVideoSrc($data['video_src']);
        $post->setCuisineCountry($data['cuisine_country']);
        $post->setCuisineType($data['cuisine_type']);
        $post->setRestaurantStreet($data['restaurant_street']);
        $post->setRecommendedRestaurant($data['recommended_restaurant']);
        $post->setCity($data['city']);
        $post->setStatus($data['status']);

        /* Upload image */
        if ($_FILES && $_FILES['image']) {
            $image = $_FILES['image'];
            if ($image['error'] == 0) {
                move_uploaded_file($image['tmp_name'],
                    "public/img/uploads/" . $image['name']);
                $post->setImage("/img/uploads/" . $image['name']);
            }
        }

        // Add tags to post
        $this->addTagsToPost($data['tags'], $post);

        // Apply changes to database.
        $this->entityManager->flush();
    }

    /**
     * This method allows to update views.
     */
    public function updateViews($post, $views)
    {
        $post->setViews($views);

        // Apply changes to database.
        $this->entityManager->flush();
    }

    /**
     * Adds/updates tags in the given post.
     */
    private function addTagsToPost($tagsStr, $post)
    {
        // Remove tag associations (if any)
        $tags = $post->getTags();
        foreach ($tags as $tag) {
            $post->removeTagAssociation($tag);
        }

        // Add tags to post
        $tags = explode(',', $tagsStr);
        foreach ($tags as $tagName) {

            $tagName = StaticFilter::execute($tagName, 'StringTrim');
            if (empty($tagName)) {
                continue;
            }

            $tag = $this->entityManager->getRepository(Tag::class)
                ->findOneByName($tagName);
            if ($tag == null)
                $tag = new Tag();

            $tag->setName($tagName);
            $tag->addPost($post);

            $this->entityManager->persist($tag);

            $post->addTag($tag);
        }
    }

    /**
     * Returns status as a string.
     */
    public function getPostStatusAsString($post)
    {
        switch ($post->getStatus()) {
            case Post::STATUS_DRAFT:
                return 'Draft';
            case Post::STATUS_PUBLISHED:
                return 'Published';
        }

        return 'Unknown';
    }

    /**
     * Converts tags of the given post to comma separated list (string).
     */
    public function convertTagsToString($post)
    {
        $tags = $post->getTags();
        $tagCount = count($tags);
        $tagsStr = '';
        $i = 0;
        foreach ($tags as $tag) {
            $i++;
            $tagsStr .= $tag->getName();
            if ($i < $tagCount)
                $tagsStr .= ', ';
        }

        return $tagsStr;
    }

    /**
     * Converts tags of the given post to comma separated links (string).
     */
    public function convertTagsToLinks($post)
    {
        $tags = $post->getTags();
        $tagCount = count($tags);
        $tagsStr = '';
        $i = 0;
        foreach ($tags as $tag) {
            $i++;
            $tagsStr .= '<a href="/recipes/tag/' . $tag->getName() . '">' . $tag->getName() . '</a>';
            if ($i < $tagCount)
                $tagsStr .= ', ';
        }

        return $tagsStr;
    }

    /**
     * Returns count of comments for given post as properly formatted string.
     */
    public function getCommentCountStr($post)
    {
        $commentCount = count($post->getComments());
        if ($commentCount == 0)
            return 'No comments';
        else if ($commentCount == 1)
            return '1 comment';
        else
            return $commentCount . ' comments';
    }


    /**
     * This method adds a new comment to post.
     */
    public function addCommentToPost($post, $data)
    {
        // Create new Comment entity.
        $comment = new Comment();
        $comment->setPost($post);
        $comment->setAuthor($data['author']);
        $comment->setContent($data['comment']);
        $currentDate = date('Y-m-d H:i:s');
        $comment->setDateCreated($currentDate);

        // Add the entity to entity manager.
        $this->entityManager->persist($comment);

        // Apply changes.
        $this->entityManager->flush();
    }

    /**
     * Removes post and all associated comments.
     */
    public function removePost($post)
    {
        // Remove associated comments
        $comments = $post->getComments();
        foreach ($comments as $comment) {
            $this->entityManager->remove($comment);
        }

        // Remove tag associations (if any)
        $tags = $post->getTags();
        foreach ($tags as $tag) {

            $post->removeTagAssociation($tag);
        }

        $this->entityManager->remove($post);

        $this->entityManager->flush();
    }

    /**
     * Calculates frequencies of tag usage.
     */
    public function getTagCloud()
    {
        $tagCloud = [];

        $tags = $this->entityManager->getRepository(Tag::class)
            ->findAll();
        foreach ($tags as $tag) {

            $postsByTag = $this->entityManager->getRepository(Post::class)
                ->findPostsByTag($tag->getName())->getResult();

            $postCount = count($postsByTag);
            if ($postCount > 0) {
                $tagCloud[$tag->getName()] = $postCount;
            }
        }

        $normalizedTagCloud = [];

        // Normalize
        foreach ($tagCloud as $name => $postCount) {
            $normalizedTagCloud[$name] = $postCount;
        }

        return $normalizedTagCloud;
    }

    /**
     * Returns count of views.
     */
    public function getViewsCountStr($post)
    {
        $viewsCount = $post->getViews();
        if ($viewsCount == 0)
            return 'No views';
        else if ($viewsCount == 1)
            return '1 view';
        else
            return $viewsCount . ' views';
    }
}



