<?php


namespace V9\RabbitMQ\Queue;


use Illuminate\Queue\QueueManager;
use Illuminate\Support\ServiceProvider;

class QueueServiceProvider extends ServiceProvider
{
    public function register()
    {
        /** @var QueueManager $queue */
        $queue = $this->app['queue'];
        $connector = new V9QueueConnector;
        $queue->stopping(function () use ($connector) {
            $connector->connection()->close();
        });
        $queue->addConnector('rabbitmq', function () use ($connector) {
            return $connector;
        });
    }

    /**
     * Register the application's event listeners.
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . "./../../config/queue.php", "queue.connections.rabbitmq");
    }
}