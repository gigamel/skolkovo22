<?php

namespace App\Action\Cart;

use Skolkovo22\Http\ClientMessageInterface;
use Skolkovo22\Http\ServerMessage;
use Skolkovo22\Http\ServerMessageInterface;

class Action extends \App\Action\AbstractAction
{
    /**
     * @inheritDoc
     */
    public function __invoke(
        ClientMessageInterface $request
    ): ServerMessageInterface {
        return new ServerMessage('Hello from cart!');
    }
}
