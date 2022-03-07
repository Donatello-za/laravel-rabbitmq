<?php


namespace V9\RabbitMQ\Messaging\Sub;


use Closure;
use V9\RabbitMQ\Messaging\V9Messaging;

class Consumer extends V9Messaging implements ConsumeInterface
{
    public function route($routes, Closure $callback, $configKey = 'consume')
    {
        $queueName = $this->setup($configKey, $routes);
        $this->consume($queueName, $callback, $routes);
        $this->close();
    }
}