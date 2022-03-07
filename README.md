RabbitMQ Queue driver for Laravel/Lumen 5.4+
======================

# IMPORTANT

This is not a direct fork but is a clone of a package called `kenokokoro/laravel-rabbitmq` of a package that
dissapeared from github. This repistory is an unsupported place-holder until a working alternative is implemented.

## Description
Laravel/Lumen wrapper for RabbitMQ queue (queue - worker) and messaging ( pub - sub). This package uses separate 
configuration options for the Laravel\Lumen queue extension, and another implementation for Pub\Sub.

## Installation

1. Install this package via composer using:

    `composer require kenokokoro/laravel-rabbitmq`

2. Add the Service Provider

    - For Laravel use the `providers` section in the `config/app.php` file `V9\RabbitMQ\ServiceProvider::class,`. 
    Afterwards just publish the configuration using: `php artisan vendor:publish --provider=V9\RabbitMQ\ServiceProvider --tag=config`
    
    - For Lumen use `$app->register(V9\RabbitMQ\ServiceProvider::class)` in your `bootstrap/app.php` file. After that 
    you will have to create new file in your config folder: `config/messaging.php` and put the sample content from the
    `messaging-sample.php` file found in: `vendor/kenokokoro/laravel-rabbitmq/config/messaging-sample.php`. Finally
    just include this configuration file inside your `bootstrap/app.php` file using: `$app->configure('messaging')`

3. Even though the both implementations have different configuration, the connection configuration is same for both

		QUEUE_DRIVER=rabbitmq
		RABBITMQ_HOST=127.0.0.1
		RABBITMQ_PORT=5672
		RABBITMQ_VHOST=/
		RABBITMQ_LOGIN=guest
		RABBITMQ_PASSWORD=guest
		
	List of available environment values can be found in: `vendor/kenokokoro/laravel-rabbitmq/config/queue.php`
	
	*NOTE: The environment configuration values are used only in the laravel queue extension. For the messaging (pub - sub)
	it is used different type of configuration*

## Usage
1. Queue ([Laravel official documentation](https://laravel.com/docs/5.4/queues))
    - On Laravel: `Queue::push(App\Jobs\DummyJob::class)`
    - On Lumen you can use the same if you have `$app->withFacades()` added in your `boostrap/app.php` file, or 
    simply `app('queue')->push(App\Jobs\SomeJob::class)`
    - To consume either of this just simply use the Laravel\Lumen queue worker: `php artisan queue:work`
    
2. Messaging

    The messaging is using different configuration for queue management (except for the rabbitmq connection). 
    To get in touch for some examples of how the rabbitmq exchange and queue parameters are important check the
    [RabbitMQ examples](https://www.rabbitmq.com/tutorials/tutorial-three-php.html)
    
    1. Using dependency injection
    
        Publishing example:
        ```
        <?php
        namespace App\Console\Commands;
        use Illuminate\Console\Command;
        use V9\RabbitMQ\Messaging\Pub\PublishInterface;
        use V9\RabbitMQ\Messaging\Pub\Data;
        class PublishCommand extends Command
        {
            protected $signature = 'publish';
            /**
             * @var PublishInterface
             */
            private $publish;

            public function __construct(PublishInterface $publish)
            {
                parent::__construct();
                $this->publish = $publish;
            }

            public function handle()
            {
                $this->publish->route(['test.1', 'test.2', 'test.3'], str_random());
                # Or if you want to send array you can use the dedicated class
                # $this->publish->route(['test.1', 'test.2', 'test.3'], new Data(['hello' => 'world']);
            }
        }
        ```
    
        Consuming the publisher example:
        ```
        <?php
        namespace App\Console\Commands;
        use Illuminate\Console\Command;
        use PhpAmqpLib\Message\AMQPMessage;
        use V9\RabbitMQ\Messaging\Sub\ConsumeInterface;
        class DummyCommand extends Command
        {
            protected $signature = 'consume';

            /**
             * @var ConsumeInterface
             */
            private $consume;

            public function __construct(ConsumeInterface $consume)
            {
                parent::__construct();
                $this->consume = $consume;
            }

            public function handle()
            {
                $this->consume->route(['test.*'], function ($msg) {
                    return $this->msg($msg);
                });
            }

            private function msg(AMQPMessage $msg)
            {
                $this->line($msg->body);
            }
        }
        ```
    
    2. The same can be achieved using `app(V9\RabbitMQ\Messaging\Sub\ConsumeInterface::class)` or `app(V9\RabbitMQ\Messaging\Pub\PublishInterface:class)`
    
## License
The Laravel\Lumen RabbitMQ package is open-sourced software licensed 
under the [MIT license](http://opensource.org/licenses/MIT).
