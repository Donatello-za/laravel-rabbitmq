<?php

/*
This configuration is merged with queue.php configuration.
 */
return [
    'driver' => 'rabbitmq',
    'host' => env('RABBITMQ_HOST', '127.0.0.1'),
    'port' => env('RABBITMQ_PORT', 5672),
    'vhost' => env('RABBITMQ_VHOST', '/'),
    'login' => env('RABBITMQ_LOGIN', 'guest'),
    'password' => env('RABBITMQ_PASSWORD', 'guest'),
    /*
    * The name of default queue.
    */
    'queue' => env('RABBITMQ_QUEUE', 'default'),
    /*
    * Determine if exchange should be created if it does not exist.
    */
    'exchange_declare' => env('RABBITMQ_EXCHANGE_DECLARE', false),
    /*
    * Determine if queue should be created and binded to the exchange if it does not exist.
    */
    'queue_declare_bind' => env('RABBITMQ_QUEUE_DECLARE_BIND', true),
    /*
    * Read more about possible values at https://www.rabbitmq.com/tutorials/amqp-concepts.html
    */
    'queue_params' => [
        'passive' => env('RABBITMQ_QUEUE_PASSIVE', false),
        'durable' => env('RABBITMQ_QUEUE_DURABLE', true),
        'exclusive' => env('RABBITMQ_QUEUE_EXCLUSIVE', false),
        'auto_delete' => env('RABBITMQ_QUEUE_AUTODELETE', false),
    ],
    'exchange_params' => [
        'name' => env('RABBITMQ_EXCHANGE_NAME', 'amq.direct'),
        'type' => env('RABBITMQ_EXCHANGE_TYPE', 'direct'),
        'passive' => env('RABBITMQ_EXCHANGE_PASSIVE', false),
        'durable' => env('RABBITMQ_EXCHANGE_DURABLE', true),
        'auto_delete' => env('RABBITMQ_EXCHANGE_AUTODELETE', false),
    ],
    /*
    * Determine the number of seconds to sleep if there's an error communicating with rabbitmq
    * If set to false, it'll throw an exception rather than doing the sleep for X seconds.
    */
    'sleep_on_error' => env('RABBITMQ_ERROR_SLEEP', 5),
];