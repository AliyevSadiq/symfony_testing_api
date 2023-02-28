<?php


namespace App\CQRS\CommandBus\Handlers\Auth;

use App\CQRS\CommandBus\CommandHandler;
use App\CQRS\CommandBus\Commands\Auth\EmailVerifiedCommand;
use App\CQRS\CommandBus\Commands\Auth\RegistrationCommand;
use App\CQRS\CommandBus\Commands\Category\SaveCategoryCommand;
use App\Entity\Category;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifiedCommandHandler implements CommandHandler
{

    public function __construct(private UserRepository $repository, private VerifyEmailHelperInterface $verifyEmailHelper)
    {
    }


    public function __invoke(EmailVerifiedCommand $command)
    {
        try {
            if ($command->user_id === null) {
                throw new \Exception('user id not defined');
            }

            $user = $this->repository->find($command->user_id);

            if ($user === null) {
                throw new \Exception('user not found');
            }

            $this->verifyEmailHelper->validateEmailConfirmation($command->url, $user->getId(), $user->getEmail());

            $user->setIsVerified(true);
            $this->repository->save($user, true);

        } catch (VerifyEmailExceptionInterface $exception) {
            throw new \Exception($exception->getMessage());
        }

    }
}