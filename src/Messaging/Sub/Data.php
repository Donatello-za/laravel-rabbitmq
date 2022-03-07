<?php


namespace V9\RabbitMQ\Messaging\Sub;


class Data
{
    protected $attributes = [];

    public function __construct($attributes)
    {
        if (is_string($attributes)) {
            $attributes = json_decode($attributes, true);
        }

        $this->attributes = $attributes;
    }

    public static function process(string $stringAttributes)
    {
        return new self($stringAttributes);
    }

    public function attributes()
    {
        return $this->attributes;
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }
}