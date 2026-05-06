<?php
declare(strict_types=1);

namespace RecaptchaV3\Middleware;

use Cake\Http\Exception\BadRequestException;
use Cake\Http\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RecaptchaV3\Service\RecaptchaV3Service;

/**
 * RecaptchaV3 middleware
 */
class RecaptchaV3Middleware implements MiddlewareInterface
{
    /**
     * @param RecaptchaV3Service $recaptchaV3 The RecaptchaV3 service
     * @param bool $sendRemoteIp Flag to send remote client IP to recaptcha service
     */
    public function __construct(private RecaptchaV3Service $recaptchaV3, private bool $sendRemoteIp = false)
    {
    }

    /**
     * Find and return the client IP address
     * 
     * @param ServerRequestInterface $request
     * @return string
     */
    private function getClientIp(ServerRequestInterface $request): string
    {
        if ($request instanceof ServerRequest) {
            return $request->clientIp();
        }

        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Process method.
     *
     * @param \Cake\Http\ServerRequest $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getMethod() === 'POST') {
            /** @var array $parsedBody */
            $parsedBody = $request->getParsedBody();

            if (!array_key_exists('g-recaptcha-response', $parsedBody)) {
                throw new BadRequestException('Request body is missing required g-recaptcha-response field');
            }

            $clientIp = null;

            if ($this->sendRemoteIp) {
                $clientIp = $this->getClientIp($request);
            }

            $result = $this->recaptchaV3->verifyRecaptchaResponse($parsedBody['g-recaptcha-response'], $clientIp);
            $request = $request->withAttribute('recaptchaV3Result', $result);
            $response = $handler->handle($request);

            // This is a developerland check to ensure the result is checked at some point in the lifecycle.
            // The controller action, and other middleware, will still execute, before this code is reached, 
            // if a check is not performed and handled respectively in the request lifecycle.
            if (!$result->isValidated()) {
                throw new BadRequestException('Recaptcha response has not been validated');
            }

            return $response;
        }

        return $handler->handle($request);
    }
}
