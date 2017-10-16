<?php

namespace Application;

use Application\Controller\IndexController;
use Zend\Router\Http\Literal;

return [
    'routes' => [
        'home' => [
            'type'    => Literal::class,
            'options' => [
                'route'    => '/',
                'defaults' => [
                    'controller' => IndexController::class,
                    'action'     => 'index',
                ],
            ],
        ],
    ],
];