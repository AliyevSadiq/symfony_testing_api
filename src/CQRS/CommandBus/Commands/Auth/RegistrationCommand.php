<?php


namespace App\CQRS\CommandBus\Commands\Auth;


use App\CQRS\CommandBus\AbstractCommand;

class RegistrationCommand extends AbstractCommand
{
    public string $email;
    public string $username;
    public string $password;
}