<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{


    #[Route('/me', 'profile')]
    public function profile()
    {
        return $this->json([
            'user' => $this->getUser()
        ]);
    }

    #[Route('/logout', name: 'logout',methods: ['GET'])]
    public function logout()
    {
        throw new \Exception('should not be reached');
    }
}
