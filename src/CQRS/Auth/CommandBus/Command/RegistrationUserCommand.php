<?php

namespace App\CQRS\Auth\CommandBus\Command;

use App\CQRS\Common\Command\Command;
use App\Entity\User;

class RegistrationUserCommand implements Command
{


    public string $email;
    public string $password;

    public User $user;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}