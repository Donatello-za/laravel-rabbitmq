<?php


namespace V9\RabbitMQ\Messaging\Sub;


use Closure;

interface ConsumeInterface
{
    /**
     * @param mixed $routes
     * @param Closure $callback
     * @param string $configKey
     * @return mixed
     */
    public function route($routes, Closure $callback, $configKey = 'consume');
}