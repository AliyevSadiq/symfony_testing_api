<?php


namespace App\CQRS\CommandBus;



abstract class AbstractCommand implements Command
{
    use MessageTrait;
}