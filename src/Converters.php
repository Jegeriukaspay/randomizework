<?php

namespace Jegeriukaspay\Randomizework;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class Converters
{
    public function randomConvert($data)
    {
        $containerBuilder = $this->createContainer();

        extract($this->getConvertersInfoFromContainer($containerBuilder));

        $selected_converter = $converters[$this->selectRandomConverter($count)];
        $converter = $containerBuilder->get($selected_converter);

        return $converter->handle($data);

    }

    private function getConvertersInfoFromContainer($containerBuilder)
    {
        $converters = array_keys($containerBuilder->findTaggedServiceIds('app.converter'));
        //print_r($converters);
        return [
            "count" => count($converters) - 1,
            "converters" => $converters
        ];
    }

    private function selectRandomConverter($limit)
    {
        return rand(0, $limit);
    }

    private function createContainer()
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->register('ConverterPattern', ConverterPattern::class)
            ->addTag('app.converter');

        $containerBuilder->register('ConverterRot', ConverterRot::class)
            ->addTag('app.converter');

        return $containerBuilder;
    }
}