<?php


namespace App\Utils\Contract;


abstract class AbstractResourceCollection
{
   private array $data;
   public function __construct($resource)
   {
       $this->data=$this->field($resource);
   }


   abstract protected function field($item);

    public function get()
    {
        return $this->data;
   }
}