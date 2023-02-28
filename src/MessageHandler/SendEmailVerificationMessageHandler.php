<?php

namespace App\MessageHandler;

use App\Message\SendEmailVerificationMessage;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Message;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

final class SendEmailVerificationMessageHandler implements MessageHandlerInterface
{
    public function __construct(private MailerInterface $mailer,private VerifyEmailHelperInterface $helper)
    {
    }


    public function __invoke(SendEmailVerificationMessage $message)
    {
        $signatureComponents = $this->helper->generateSignature(
            'email_verification',
            $message->getUser()->getId(),
            $message->getUser()->getEmail(),
            ['id'=>$message->getUser()->getId()]
        );
        $email = new TemplatedEmail();
        $email->from('send@example.com');
        $email->to($message->getUser()->getEmail());
        $email->htmlTemplate('registration/confirmation_email.html.twig');
        $email->context(['signedUrl' => $signatureComponents->getSignedUrl()]);

        $this->mailer->send($email);
    }
}
