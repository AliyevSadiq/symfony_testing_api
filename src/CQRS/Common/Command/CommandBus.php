<?php

namespace App\CQRS\Common\Command;

interface CommandBus
{
    public function dispatch(Command $command): void;
}