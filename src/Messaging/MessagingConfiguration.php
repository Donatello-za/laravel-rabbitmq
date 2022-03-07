<?php


namespace V9\RabbitMQ\Messaging;


use Illuminate\Support\Collection;

class MessagingConfiguration
{
    /**
     * @var Collection
     */
    private $config;

    /**
     * @var string|null
     */
    private $route;

    public function __construct(array $config, array $route = [''])
    {
        $this->config = collect($config);
        $this->route = $route;
    }

    public function init(array $config, $route = null)
    {
        return new self($config, $route);
    }

    public function routes()
    {
        return $this->route;
    }

    public function declareExchange()
    {
        return $this->config->get('exchange_declare');
    }

    public function bindQueue()
    {
        return $this->config->get('queue_declare_bind');
    }

    public function queueConfig()
    {
        return $this->config->get('queue_params');
    }

    public function exchangeConfig()
    {
        return $this->config->get('exchange_params');
    }

    public function queueConfigParam($key)
    {
        return collect($this->queueConfig())->get($key);
    }

    public function exchangeConfigParam($key)
    {
        return collect($this->exchangeConfig())->get($key);
    }
}