<?php


namespace V9\RabbitMQ\Messaging;


use Closure;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use V9\RabbitMQ\Messaging\Pub\PublishInterface;
use V9\RabbitMQ\Messaging\Sub\ConsumeInterface;

class V9Messaging
{
    /**
     * @var Connector
     */
    protected $connector;

    /**
     * @var AMQPChannel
     */
    protected $channel;

    /**
     * @var MessagingConfiguration
     */
    protected $config;

    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
        $this->channel = $this->connection()->channel();
    }

    public function __call($method, $arguments)
    {
        /** @var PublishInterface $publisher */
        $publisher = app(PublishInterface::class);
        /** @var ConsumeInterface $consumer */
        $consumer = app(ConsumeInterface::class);

        if (method_exists($publisher, $method)) {
            return $publisher->{$method}(...$arguments);
        }

        return $consumer->{$method}(...$arguments);
    }

    protected function connection()
    {
        return $this->connector->connection();
    }

    protected function close()
    {
        $this->channel->close();
        $this->connection()->close();
    }

    protected function setup($configKey, $routes)
    {
        if (is_string($routes)) {
            $routes = [$routes];
        }

        $this->config = new MessagingConfiguration(config("messaging.setups.{$configKey}"), $routes);

        if ($this->config->declareExchange()) {
            $this->channel->exchange_declare(...array_values($this->config->exchangeConfig()));
        }

        if ($this->config->bindQueue()) {
            [$queueName] = $this->channel->queue_declare(...array_values($this->config->queueConfig()));

            foreach ($routes as $route) {
                $this->channel->queue_bind($queueName, $this->config->exchangeConfigParam('name'), $route);
            }
        }

        return $queueName ?? null;
    }

    protected function publish(AMQPMessage $message)
    {
        foreach ($this->config->routes() as $route) {
            $this->channel->basic_publish($message, $this->config->exchangeConfigParam('name'), $route);
        }
    }

    protected function consume($queueName, Closure $callback, $routes)
    {
        if (count($routes) > 1) {
            $this->channel->basic_consume($queueName, '', false, true, false, false, $callback);
        } else {
            $this->channel->basic_consume($queueName, $routes[0], false, true, false, false, $callback);
        }

        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
}