<?php
namespace Services;
class ConverterPattern
{
    private const pattern = '/^[0-9]*$/';
    public function __construct(){

    }

    public function handle($data){
        if(!is_array($data)) return $this->stringConvert($data);

        foreach($data as $key=>$string){
            $data[$key] = $this->stringConvert($string);
        }
        return $data;
    }
    private function stringConvert(string $string):string
    {
        $string = strtolower($string);
        $array = [];
        foreach (str_split($string) as $char) {
            $array[] = preg_match(self::pattern, $char) ? $char : $this->charValueToInt($char);
        }
        return implode('/', $array);
    }
    private function charValueToInt($char)
    {
        return ord($char) - 96;
    }
}