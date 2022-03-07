<?php

return [
    'setups' => [
        'consume' => [
            'exchange_declare' => true,
            'queue_declare_bind' => true,
            'queue_params' => [
                'queue' => '',
                'passive' => false,
                'durable' => false,
                'exclusive' => true,
                'auto_delete' => false,
            ],
            'exchange_params' => [
                'name' => 'pubsub',
                'type' => 'topic',
                'passive' => false,
                'durable' => false,
                'auto_delete' => false,
            ],
        ],
        'publish' => [
            'exchange_declare' => true,
            'queue_declare_bind' => false,
            'queue_params' => [
                'queue' => '',
                'passive' => false,
                'durable' => false,
                'exclusive' => true,
                'auto_delete' => false,
            ],
            'exchange_params' => [
                'name' => 'pubsub',
                'type' => 'topic',
                'passive' => false,
                'durable' => false,
                'auto_delete' => false,
            ],
        ]
    ]
];
