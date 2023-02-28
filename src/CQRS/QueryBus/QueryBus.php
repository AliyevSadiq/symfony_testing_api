<?php


namespace App\CQRS\QueryBus;


interface QueryBus
{
    public function handle(Query $query);
}