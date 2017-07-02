<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Application\Entity\Post;

/**
 * This is the main controller class of the Blog application. The
 * controller class is used to receive user input,
 * pass the data to the models and pass the results returned by models to the
 * view for rendering.
 */
class IndexController extends AbstractActionController
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
     * This is the default "index" action of the controller. It displays the
     * Recent Posts page containing the recent blog posts.
     */
    public function indexAction()
    {
        $page = $this->params()->fromQuery('page', 1);

        // Get recent posts
        $query = $this->entityManager->getRepository(Post::class)->findPublishedPosts();

        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(15);
        $paginator->setCurrentPageNumber($page);

        /* Change layout */
        $this->layout()->setTemplate('layout/layout-front');

        /* Latest 3 posts */
        $latestPosts = $this->entityManager->getRepository(Post::class)->findLatestPosts(2);

        /* Countries List */
        $countries = $this->entityManager->getRepository(Post::class)->getCountries();

        /* Cuisine Types list */
        $types = $this->entityManager->getRepository(Post::class)->getCuisineTypes();

        // Render the view template.
        return new ViewModel([
            'posts' => $paginator,
            'postManager' => $this->postManager,
            'countries' => $countries,
            'types' => $types,
            'latestPosts' => $latestPosts
        ]);
    }

    /**
     * Recent Posts based by tag filter.
     */
    public function tagsfilterAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $filter = $this->params()->fromRoute('tag', null);

        // Filter posts by tag
        $query = $this->entityManager->getRepository(Post::class)->findPostsByTag($filter);

        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(15);
        $paginator->setCurrentPageNumber($page);

        /* Change layout */
        $this->layout()->setTemplate('layout/layout-front');

        /* Latest 3 posts */
        $latestPosts = $this->entityManager->getRepository(Post::class)->findLatestPosts(2);

        /* Countries List */
        $countries = $this->entityManager->getRepository(Post::class)->getCountries();

        /* Cuisine Types list */
        $types = $this->entityManager->getRepository(Post::class)->getCuisineTypes();

        // Render the view template.
        return new ViewModel([
            'posts' => $paginator,
            'postManager' => $this->postManager,
            'countries' => $countries,
            'types' => $types,
            'latestPosts' => $latestPosts
        ]);
    }

    /**
     * Recent Posts based by country filter.
     */
    public function countryfilterAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $filter = $this->params()->fromRoute('country', null);

        // Filter posts by Country
        $query = $this->entityManager->getRepository(Post::class)->findPostsByCountry($filter);

        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(15);
        $paginator->setCurrentPageNumber($page);

        /* Change layout */
        $this->layout()->setTemplate('layout/layout-front');

        /* Latest 3 posts */
        $latestPosts = $this->entityManager->getRepository(Post::class)->findLatestPosts(2);

        /* Countries List */
        $countries = $this->entityManager->getRepository(Post::class)->getCountries();

        /* Cuisine Types list */
        $types = $this->entityManager->getRepository(Post::class)->getCuisineTypes();

        // Render the view template.
        return new ViewModel([
            'posts' => $paginator,
            'postManager' => $this->postManager,
            'countries' => $countries,
            'types' => $types,
            'latestPosts' => $latestPosts
        ]);
    }

    /**
     * Recent Posts based by type filter.
     */
    public function typefilterAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $filter = $this->params()->fromRoute('type', null);

        // Filter posts by type
        $query = $this->entityManager->getRepository(Post::class)->findPostsByCuisineType($filter);

        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(15);
        $paginator->setCurrentPageNumber($page);

        /* Change layout */
        $this->layout()->setTemplate('layout/layout-front');

        /* Latest 3 posts */
        $latestPosts = $this->entityManager->getRepository(Post::class)->findLatestPosts(2);

        /* Countries List */
        $countries = $this->entityManager->getRepository(Post::class)->getCountries();

        /* Cuisine Types list */
        $types = $this->entityManager->getRepository(Post::class)->getCuisineTypes();

        // Render the view template.
        return new ViewModel([
            'posts' => $paginator,
            'postManager' => $this->postManager,
            'countries' => $countries,
            'types' => $types,
            'latestPosts' => $latestPosts
        ]);
    }

    /**
     * Search Posts based by type search query.
     */
    public function searchAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $filter = $this->params()->fromQuery('s', '');

        // Filter posts by type
        $query = $this->entityManager->getRepository(Post::class)->findPostsBySearchQuery($filter);

        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(15);
        $paginator->setCurrentPageNumber($page);

        /* Change layout */
        $this->layout()->setTemplate('layout/layout-front');

        /* Latest 3 posts */
        $latestPosts = $this->entityManager->getRepository(Post::class)->findLatestPosts(2);

        /* Countries List */
        $countries = $this->entityManager->getRepository(Post::class)->getCountries();

        /* Cuisine Types list */
        $types = $this->entityManager->getRepository(Post::class)->getCuisineTypes();

        // Render the view template.
        return new ViewModel([
            'posts' => $paginator,
            'postManager' => $this->postManager,
            'countries' => $countries,
            'types' => $types,
            'latestPosts' => $latestPosts
        ]);
    }

    /**
     * This action displays the About page.
     */
    public function aboutAction()
    {
        $appName = 'Cuisine Tourism';
        $appDescription = 'Cuisine Tourism Website';
        /* Change layout */
        $this->layout()->setTemplate('layout/layout-front');
        /* Latest 3 posts */
        $latestPosts = $this->entityManager->getRepository(Post::class)->findLatestPosts(2);
        /* Countries List */
        $countries = $this->entityManager->getRepository(Post::class)->getCountries();
        /* Cuisine Types list */
        $types = $this->entityManager->getRepository(Post::class)->getCuisineTypes();
        // Render the view template.
        return new ViewModel([
            'countries' => $countries,
            'types' => $types,
            'latestPosts' => $latestPosts
        ]);
    }
}
