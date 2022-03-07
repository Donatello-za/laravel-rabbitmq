<?php


namespace V9\RabbitMQ\Queue;


use Illuminate\Contracts\Queue\Queue;
use Illuminate\Queue\Connectors\ConnectorInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class V9QueueConnector implements ConnectorInterface
{
    private $connection;

    /**
     * Establish a queue connection.
     * @param  array $config
     * @return Queue
     */
    public function connect(array $config)
    {
        // create connection with AMQP
        $this->connection = new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['login'],
            $config['password'],
            $config['vhost']
        );

        return new V9Queue($this->connection, $config);
    }

    /**
     * @return AMQPStreamConnection
     */
    public function connection()
    {
        return $this->connection;
    }
}