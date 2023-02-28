<?php


namespace App\CQRS\CommandBus\Handlers\Auth;

use App\CQRS\CommandBus\CommandHandler;
use App\CQRS\CommandBus\Commands\Auth\ResetPasswordCommand;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class ResetPasswordCommandHandler implements CommandHandler
{

    public function __construct(
        private UserRepository $repository,
        private ResetPasswordHelperInterface $resetPasswordHelper,
        private MailerInterface $mailer
    )
    {
    }


    public function __invoke(ResetPasswordCommand $command)
    {
        try {
          $user=$this->repository->findOneBy(['email'=>$command->email]);

          if ($user===null){
              throw new \Exception('user not found');
          }

            $resetToken = $this->resetPasswordHelper->generateResetToken($user);

            $email = (new TemplatedEmail())
                ->from(new Address('adminer@mail.com', 'Adminer'))
                ->to($user->getEmail())
                ->subject('Your password reset request')
                ->htmlTemplate('reset_password/email.html.twig')
                ->context([
                    'resetToken' => $resetToken,
                ])
            ;

            $this->mailer->send($email);

        } catch (ResetPasswordExceptionInterface $exception) {
            throw new \Exception($exception->getMessage());
        }

    }
}