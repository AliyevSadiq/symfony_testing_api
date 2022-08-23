<?php

namespace App\Controller;

use App\Request\LoginRequest;
use App\Request\RegisterRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/auth', name: 'auth_')]
class AuthController extends AbstractController
{

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(RegisterRequest $request)
    {

    }

    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(LoginRequest $request)
    {

    }
}
