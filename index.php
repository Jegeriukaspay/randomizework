<?php
require_once(__DIR__ . '/vendor/autoload.php');

$limit = 6;
$array_limit = 8;
$collections = (new \Jegeriukaspay\Randomizework\Generators())
    ->getGenerators($limit, $array_limit);
$converter = new \Jegeriukaspay\Randomizework\Converters();
$converted = [];
foreach ($collections as $collection) {
    $converted[] = $converter->randomConvert($collection);
}
echo "<pre>";
print_r($collections);
print_r($converted);
echo "</pre>";

