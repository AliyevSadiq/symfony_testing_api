<?php


namespace App\CQRS\CommandBus;


trait MessageTrait
{
    /**
     * Инициализирует объект значениями из указанного массива.
     *
     * @param array $values Массив с начальными значениями объекта.
     */
    public function __construct(array $values = [])
    {
        foreach ($values as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }
}