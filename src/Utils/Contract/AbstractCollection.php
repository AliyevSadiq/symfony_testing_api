<?php


namespace App\Utils\Contract;


abstract class AbstractCollection implements CollectionInterface
{

    public static function collection($collection)
    {
        $data=[];

        foreach ($collection as $item){
            $data['data'][]=static::field($item);
        }

        return $data;
    }

    abstract protected static function field($item);
}