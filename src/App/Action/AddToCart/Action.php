<?php

namespace App\Action\AddToCart;

use Skolkovo22\Http\ClientMessageInterface;
use Skolkovo22\Http\ServerMessageInterface;

class Action extends \App\Action\AbstractAction
{
    /**
     * @inheritDoc
     */
    public function __invoke(
        ClientMessageInterface $request
    ): ServerMessageInterface {
        return new \Skolkovo22\Http\ServerMessage(
            'It\'s page of adding to cart module.'
        );
    }
}
