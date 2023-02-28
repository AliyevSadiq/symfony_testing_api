<?php


namespace App\Security;

use App\Repository\RefreshTokenRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class JwtAuthenticator extends AbstractAuthenticator
{

    public function __construct(private JWTTokenManagerInterface $tokenStorageInterface,private RefreshTokenRepository $repository)
    {

    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization') && str_starts_with($request->headers->get('Authorization'), 'Bearer ');
    }

    public function authenticate(Request $request): SelfValidatingPassport
    {
        try{
            $authorizationHeader = $request->headers->get('Authorization');
            $apiToken = str_replace('Bearer ', '', $authorizationHeader);
            if (null === $apiToken) {
                throw new AuthenticationException('JWT token not provided',401);
            }

            $token_parse=$this->tokenStorageInterface->parse($apiToken);

            $user_exist=$this->repository->findBy(['username'=>$token_parse['email']]);

            if (count($user_exist)==0){
                throw new AuthenticationException('JWT token not provided',Response::HTTP_UNAUTHORIZED);
            }

            return new SelfValidatingPassport(new UserBadge($token_parse['email']));
        }catch (JWTDecodeFailureException $JWTDecodeFailureException){
            throw new AuthenticationException('JWT token expired',Response::HTTP_UNAUTHORIZED);
        }

    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?JsonResponse
    {
        $data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}