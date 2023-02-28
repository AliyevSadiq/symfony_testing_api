<?php


namespace App\CQRS\CommandBus\Commands\User;


use App\CQRS\CommandBus\AbstractCommand;
use App\Entity\User;

class DeleteUserCommand extends AbstractCommand
{
    public User $user;
}