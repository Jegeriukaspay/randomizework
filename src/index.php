<?php
require_once(__DIR__.'/../vendor/autoload.php');

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 *
 */
class RandomArray
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

        $converters = array_keys($containerBuilder->findTaggedServiceIds('app.converter'));
        $converters_count = count($converters) - 1;

        $converted = [];
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
        $containerBuilder->register('GeneratorString', GenertorString::class)
            ->addTag('app.generator')
            ->addArgument($this->limit);
        $containerBuilder->register('Generator', GeneratorArray::class)
            ->addTag('app.generator')
            ->addArgument($this->array_limit)
            ->addArgument(new Reference('GeneratorString'));

        $containerBuilder->register('ConverterPattern', ConverterPattern::class)
            ->addTag('app.converter');
        $containerBuilder->register('ConverterRot', ConverterRot::class)
            ->addTag('app.converter');
        return $containerBuilder;
    }

}
//
//$array = (new RandomArray)->randomize(10, 15);
//echo "<pre>";
//print_r($array);
//echo "</pre>";

