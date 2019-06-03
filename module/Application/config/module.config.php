<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\Controller\LazyControllerAbstractFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Regex;
use Zend\Router\Http\Segment;
use Zend\Router\Http\TreeRouteStack;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'router_class' => TreeRouteStack::class,
        'default_params' => [
            // Укажите параметры по умолчанию для всех маршрутов ...
        ],
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'about' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/about',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'about',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'barcode' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/barcode[/:type/:label]',
                    'constraings' => [
                        'type' => '[A-Za-z]\\w*',
                        'label' => '\\w*',
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'barcode',
                    ],
                ],
            ],
            'download' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/download[/:action]',
                    'defaults' => [
                        'controller' => Controller\DownloadController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'doc' => [
                'type' => Regex::class,
                'options' => [
                    'regex'    => '/doc(?<page>\/\\w+)',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'doc',
                    ],
                    'spec'=>'/doc/%page%'
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            //Controller\IndexController::class => InvokableFactory::class,
            //Controller\IndexController::class => Controller\IndexControllerFactory::class,
            Controller\IndexController::class => LazyControllerAbstractFactory::class,
            Controller\DownloadController::class => InvokableFactory::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            Controller\Plugin\AccessPlugin::class => InvokableFactory::class,
        ],
        'aliases' => [
            'accessPlugin' => Controller\Plugin\AccessPlugin::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\CurrencyConverter::class => InvokableFactory::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            View\Helper\Params::class => View\Helper\Factory\ParamsFactory::class,
        ],
        'aliases' => [
            'params' => View\Helper\Params::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];
