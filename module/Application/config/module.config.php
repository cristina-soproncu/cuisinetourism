<?php

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\Router\Http\Regex;
use Zend\ServiceManager\Factory\InvokableFactory;
use Application\Route\StaticRoute;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'router' => [
        'routes' => [
            'index' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'application' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'about' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/about',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'about',
                    ],
                ],
            ],
            'frontview' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/recipe[/:id]',
                    'constraints' => [
                        'id' => '[0-9]*'
                    ],
                    'defaults' => [
                        'controller' => Controller\PostController::class,
                        'action' => 'view',
                    ],
                ],
            ],
            'tagsfilter' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/recipes/tag[/:tag]',
                    'constraints' => [
                        'tag' => '[a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'tagsfilter',
                    ],
                ],
            ],
            'countryfilter' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/recipes/country[/:country]',
                    'constraints' => [
                        'tag' => '[a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'countryfilter',
                    ],
                ],
            ],
            'typefilter' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/recipes/type[/:type]',
                    'constraints' => [
                        'tag' => '[a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'typefilter',
                    ],
                ],
            ],
            'search' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/recipes/search',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'search',
                    ],
                ],
            ],
            'admin' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z0-9_-]*',
                        'id' => '[0-9]*'
                    ],
                    'defaults' => [
                        'controller' => Controller\PostController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
            Controller\PostController::class => Controller\Factory\PostControllerFactory::class,
        ],
    ],
    // The 'access_filter' key is used by the User module to restrict or permit
    // access to certain controller actions for unauthorized visitors.
    'access_filter' => [
        'options' => [
            'mode' => 'restrictive'
        ],
        'controllers' => [
            Controller\IndexController::class => [
                ['actions' => ['index', 'about', 'tagsfilter', 'countryfilter', 'typefilter', 'search'], 'allow' => '*']
            ],
            Controller\PostController::class => [
                ['actions' => ['view'], 'allow' => '*']
            ],
        ]
    ],
    'service_manager' => [
        'factories' => [
            Service\PostManager::class => Service\Factory\PostManagerFactory::class,
        ],
    ],
    // The following registers our custom view 
    // helper classes in view plugin manager.
    'view_helpers' => [
        'factories' => [
            View\Helper\Menu::class => InvokableFactory::class,
            View\Helper\Breadcrumbs::class => InvokableFactory::class,
        ],
        'aliases' => [
            'mainMenu' => View\Helper\Menu::class,
            'pageBreadcrumbs' => View\Helper\Breadcrumbs::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'layout/layout-front' => __DIR__ . '/../view/layout/layout-front.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
];
