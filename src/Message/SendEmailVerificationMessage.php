<?php

namespace App\Message;

use App\Entity\User;

final class SendEmailVerificationMessage
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */


    private User $user;

    public function __construct(User $user)
     {
         $this->user = $user;
     }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }


}
