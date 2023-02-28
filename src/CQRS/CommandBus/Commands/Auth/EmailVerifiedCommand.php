<?php


namespace App\CQRS\CommandBus\Commands\Auth;


use App\CQRS\CommandBus\AbstractCommand;

class EmailVerifiedCommand extends AbstractCommand
{
    public ?int $user_id=null;
    public string $url;

}