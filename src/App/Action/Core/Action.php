<?php

namespace App\Action\Core;

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
        return new \Skolkovo22\Http\ServerMessage('There is main module...');
    }
}
