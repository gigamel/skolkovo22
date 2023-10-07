<?php

use Skolkovo22\Http\ClientMessageInterface;

return [
    'home' => [
        'method' => ClientMessageInterface::HTTP_METHOD_GET,
        'rule' => '/',
        'action' => \App\Action\Core\Action::class,
    ],
    'cart' => [
        'method' => ClientMessageInterface::HTTP_METHOD_GET,
        'rule' => '/cart/',
        'action' => \App\Action\Cart\Action::class,
    ],
    'cart.add' => [
        'method' => ClientMessageInterface::HTTP_METHOD_GET,
        'rule' => '/cart/add/',
        'action' => \App\Action\AddToCart\Action::class,
    ],
];
