<?php

class GenertorString
{
    private $limit;
    /**
     *
     */
    private const random_strings = '0123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';

    /**
     * @param string $limit
     * @return void
     */
    public function __construct(int $limit = 8)
    {
        $this->limit = $limit;
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function handle()
    {
        $string = \Symfony\Component\String\ByteString::fromRandom($this->limit, self::random_strings)->toString();
        return $string;
    }
}