<?php

return [
    'stream' => 'hello',
    'formatter' => function (string $message, string $stream) {
        if ('default' === $stream) {
            $message = str_replace('guys!', '*MASKED*', $message);
        }

        return $message;
    },
];
