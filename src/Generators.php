<?php

namespace Jegeriukaspay\Randomizework;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class Generators
{
    public function getGenerators(int $limit = 8, int $array_limit = 5) //sorry uz negrazu koda :D
    {
        $this->limit = $limit;
        $this->array_limit = $array_limit;

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->register('GeneratorString', GenertorString::class)
            ->addTag('app.generator')
            ->addArgument($this->limit);
        $containerBuilder->register('Generator', GeneratorArray::class)
            ->addTag('app.generator')
            ->addArgument($this->array_limit)
            ->addArgument(new Reference('GeneratorString'));

        $generators = $containerBuilder->findTaggedServiceIds('app.generator');

        $collections = [];
        foreach ($generators as $generator => $info) {
            $generate = $containerBuilder->get($generator);
            $collections[] = $generate->handle();
        }
        return $collections;
    }
}