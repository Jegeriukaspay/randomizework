<?php

namespace Services;
/**
 *
 */
class GeneratorArray
{
    /**
     * @var
     */
    private $generator;
    private $array_limit;

    /**
     * @param string $limit
     * @return void
     */
    public function __construct(int $array_limit = 3, GenertorString $generatorString)
    {
        $this->generator = $generatorString;
        $this->array_limit = $array_limit;
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function handle()
    {
        $array = [];
        for ($i = 0; $i < $this->array_limit; $i++) {
            $array[] = $this->generator->handle();
        }
        return $array;

    }
}