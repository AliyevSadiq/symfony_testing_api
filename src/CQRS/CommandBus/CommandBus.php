<?php


namespace App\CQRS\CommandBus;


interface CommandBus
{
    public function dispatch(Command $command): void;
}