<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\PostForm;
use Application\Entity\Post;
use Application\Form\CommentForm;

/**
 * This is the Post controller class of the Blog application.
 * This controller is used for managing posts (adding/editing/viewing/deleting).
 */
class PostController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Post manager.
     * @var Application\Service\PostManager
     */
    private $postManager;

    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct($entityManager, $postManager)
    {
        $this->entityManager = $entityManager;
        $this->postManager = $postManager;
    }

    /**
     * This action displays the "New Post" page. The page contains a form allowing
     * to enter post title, content and tags. When the user clicks the Submit button,
     * a new Post entity will be created.
     */
    public function addAction()
    {
        // Create the form.
        $form = new PostForm();

        // Check whether this post is a POST request.
        if ($this->getRequest()->isPost()) {

            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {

                // Get validated form data.
                $data = $form->getData();

                // Use post manager service to add new post to database.                
                $this->postManager->addNewPost($data);

                // Redirect the user to "index" page.
                return $this->redirect()->toRoute('admin');
            }
        }

        // Render the view template.
        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * This action displays the "View Post" page allowing to see the post title
     * and content. The page also contains a form allowing
     * to add a comment to post.
     */
    public function viewAction()
    {
        $postId = (int)$this->params()->fromRoute('id', -1);

        // Validate input parameter
        if ($postId < 0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Find the post by ID
        $post = $this->entityManager->getRepository(Post::class)->findOneById($postId);

        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Add view
        $views = $post->getViews() + 1;
        $this->postManager->updateViews($post, $views);

        // Create the form.
        $form = new CommentForm();

        // Check whether this post is a POST request.
        if ($this->getRequest()->isPost()) {

            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {

                // Get validated form data.
                $data = $form->getData();

                // Use post manager service to add new comment to post.
                $this->postManager->addCommentToPost($post, $data);

                // Redirect the user again to "view" page.
                return $this->redirect()->toRoute('admin', ['action' => 'view', 'id' => $postId]);
            }
        }

        /* Change layout */
        $this->layout()->setTemplate('layout/layout-front');

        // Get popular tags.
        $tagCloud = $this->postManager->getTagCloud();

        /* Latest 3 posts */
        $latestPosts = $this->entityManager->getRepository(Post::class)->findLatestPosts(3);

        /* Countries List */
        $countries = $this->entityManager->getRepository(Post::class)->getCountries();

        /* Cuisine Types list */
        $types = $this->entityManager->getRepository(Post::class)->getCuisineTypes();

        // Render the view template.
        return new ViewModel([
            'post' => $post,
            'form' => $form,
            'postManager' => $this->postManager,
            'tagCloud' => $tagCloud,
            'countries' => $countries,
            'types' => $types,
            'latestPosts' => $latestPosts
        ]);
    }

    /**
     * This action displays the page allowing to edit a post.
     */
    public function editAction()
    {
        // Create form.
        $form = new PostForm();

        // Get post ID.
        $postId = (int)$this->params()->fromRoute('id', -1);

        // Validate input parameter
        if ($postId < 0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Find the existing post in the database.
        $post = $this->entityManager->getRepository(Post::class)->findOneById($postId);
        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Check whether this post is a POST request.
        if ($this->getRequest()->isPost()) {

            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {

                // Get validated form data.
                $data = $form->getData();

                // Use post manager service update existing post.                
                $this->postManager->updatePost($post, $data);

                // Redirect the user to "admin" page.
                return $this->redirect()->toRoute('admin', ['action' => 'index']);
            }
        } else {
            $data = [
                'title' => $post->getTitle(),
                'original_title' => $post->getOriginalTitle(),
                'description' => $post->getDescription(),
                'short_description' => $post->getShortDescription(),
                'video_src' => $post->getVideoSrc(),
                'cuisine_country' => $post->getCuisineCountry(),
                'cuisine_type' => $post->getCuisineType(),
                'recommended_restaurant' => $post->getRecommendedRestaurant(),
                'restaurant_street' => $post->getRestaurantStreet(),
                'city' => $post->getCity(),
                'image' => $post->getImage(),
                'tags' => $this->postManager->convertTagsToString($post),
                'status' => $post->getStatus()
            ];

            $form->setData($data);
        }

        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'post' => $post
        ]);
    }

    /**
     * This "delete" action deletes the given post.
     */
    public function deleteAction()
    {
        $postId = (int)$this->params()->fromRoute('id', -1);

        // Validate input parameter
        if ($postId < 0) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $post = $this->entityManager->getRepository(Post::class)
            ->findOneById($postId);
        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $this->postManager->removePost($post);

        // Redirect the user to "admin" page.
        return $this->redirect()->toRoute('admin', ['action' => 'index']);

    }

    /**
     * This "admin" action displays the Manage Posts page. This page contains
     * the list of posts with an ability to edit/delete any post.
     */
    public function indexAction()
    {
        // Get recent posts
        $posts = $this->entityManager->getRepository(Post::class)
            ->findBy([], ['dateCreated' => 'DESC']);

        // Render the view template
        return new ViewModel([
            'posts' => $posts,
            'postManager' => $this->postManager
        ]);
    }
}
