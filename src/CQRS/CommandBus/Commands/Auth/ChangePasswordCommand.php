<?php


namespace App\CQRS\CommandBus\Commands\Auth;


use App\CQRS\CommandBus\AbstractCommand;

class ChangePasswordCommand extends AbstractCommand
{
    public ?string $token=null;
    public string $password;
}