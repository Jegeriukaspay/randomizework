<?php
require_once('./vendor/autoload.php');

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 *
 */
class funfun
{
    /**
     * @var
     */
    private $limit;
    /**
     * @var
     */
    private $array_limit;

    /**
     * @param int $limit
     * @param int $array_limit
     * @return array[]
     * @throws Exception
     */
    public function randomize(int $limit = 8, int $array_limit = 5): array
    {
        if($limit <1 || $array_limit<1) return [];
        $this->limit = $limit;
        $this->array_limit = $array_limit;

        $containerBuilder = $this->formatContainer();
        $generators = $containerBuilder->findTaggedServiceIds('app.generator');
        $collections = [];

        foreach ($generators as $generator => $info) {
            $generate = $containerBuilder->get($generator);
            $collections[] = $generate->handle();
        }
        $converted = [];
        $converters = array_keys($containerBuilder->findTaggedServiceIds('app.converter'));
        $converters_count = count($converters) - 1;

        foreach ($collections as $collection) {
            $selected_converter = $converters[rand(0, $converters_count)];
            $converter = $containerBuilder->get($selected_converter);
            $converted[] = $converter->handle($collection);
        }
        return [
            'generated' => $collections, "converted" => $converted
        ];
    }

    /**
     * @return ContainerBuilder
     */
    private function formatContainer()
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->register('GeneratorString', \Services\GenertorString::class)
            ->addTag('app.generator')
            ->addArgument($this->limit);
        $containerBuilder->register('Generator', \Services\GeneratorArray::class)
            ->addTag('app.generator')
            ->addArgument($this->array_limit)
            ->addArgument(new Reference('GeneratorString'));

        $containerBuilder->register('ConverterPattern', \Services\ConverterPattern::class)
            ->addTag('app.converter');
        $containerBuilder->register('ConverterRot', \Services\ConverterRot::class)
            ->addTag('app.converter');
        return $containerBuilder;
    }

}

//$array = (new funfun)->randomize(1, 1);
//echo "<pre>";
//print_r($array);
//
//echo "</pre>";

