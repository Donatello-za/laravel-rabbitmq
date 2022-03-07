<?php


namespace V9\RabbitMQ\Messaging;


use PhpAmqpLib\Connection\AMQPStreamConnection;

class Connector
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    public function connect(array $config = [])
    {
        if (empty($config)) {
            $config = config('queue.connections.rabbitmq');
        }

        $this->connection = new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['login'],
            $config['password'],
            $config['vhost']
        );

        return $this;
    }

    public function connection()
    {
        if (is_null($this->connection)) {
            $this->connect();
        }

        return $this->connection;
    }
}