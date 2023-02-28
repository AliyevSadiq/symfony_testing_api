<?php


namespace App\CQRS\CommandBus\Handlers\Auth;

use App\CQRS\CommandBus\CommandHandler;
use App\CQRS\CommandBus\Commands\Auth\ChangePasswordCommand;
use App\CQRS\CommandBus\Commands\Auth\ResetPasswordCommand;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class ChangePasswordCommandHandler implements CommandHandler
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private ResetPasswordHelperInterface $resetPasswordHelper,
        private UserPasswordHasherInterface $passwordHasher
    )
    {
    }


    public function __invoke(ChangePasswordCommand $command)
    {
        try {
            if ($command->token===null){
                throw new \Exception('token not found');
            }
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($command->token);

            $this->resetPasswordHelper->removeResetRequest($command->token);
            $encodedPassword = $this->passwordHasher->hashPassword(
                $user,
                $command->password
            );

            $user->setPassword($encodedPassword);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }catch (ResetPasswordExceptionInterface $exception){
            throw new \Exception($exception->getMessage());
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }

    }
}