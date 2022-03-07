<?php


namespace V9\RabbitMQ;


use Illuminate\Support\ServiceProvider as SupportServiceProvider;
use V9\RabbitMQ\Messaging\MessagingServiceProvider;
use V9\RabbitMQ\Queue\QueueServiceProvider;

class ServiceProvider extends SupportServiceProvider
{
    public function register()
    {
        $this->app->register(QueueServiceProvider::class);
        $this->app->register(MessagingServiceProvider::class);
    }
}