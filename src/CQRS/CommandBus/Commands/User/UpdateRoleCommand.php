<?php


namespace App\CQRS\CommandBus\Commands\User;


use App\CQRS\CommandBus\AbstractCommand;
use App\Entity\User;

class UpdateRoleCommand extends AbstractCommand
{
    public User $user;
    public string $role;
    public ?array $permissions=[];
}