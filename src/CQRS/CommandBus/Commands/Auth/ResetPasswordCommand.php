<?php


namespace App\CQRS\CommandBus\Commands\Auth;


use App\CQRS\CommandBus\AbstractCommand;

class ResetPasswordCommand extends AbstractCommand
{
    public string $email;
}