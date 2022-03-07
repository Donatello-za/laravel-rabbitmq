<?php


namespace V9\RabbitMQ\Messaging\Pub;


interface PublishInterface
{
    /**
     * @param mixed $routes
     * @param Data $data
     * @param string $configKey
     * @return mixed
     */
    public function route($routes, Data $data, $configKey = 'publish');
}