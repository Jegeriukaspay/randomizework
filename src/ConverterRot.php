<?php
namespace Services;
class ConverterRot
{

    public function handle($data)
    {
        if(!is_array($data)) return $this->str_rot13($data);

        foreach($data as $key=>$string){
            $data[$key] = $this->str_rot13($string);
        }
        return $data;
    }
    private function str_rot13(string $value): string
    {
        return str_rot13($value);
    }

}