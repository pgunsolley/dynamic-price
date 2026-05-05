<?php
declare(strict_types=1);

namespace RecaptchaV3\Middleware;

use Cake\Http\Exception\BadRequestException;
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
    public function __construct(private RecaptchaV3Service $recaptchaV3)
    {
    }

    /**
     * Process method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
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

            $result = $this->recaptchaV3->verifyRecaptchaResponse($parsedBody['g-recaptcha-response']);
            $request = $request->withAttribute('recaptchaV3Result', $result);
            $response = $handler->handle($request);

            // This is a developerland check to ensure the result is checked at some point in the lifecycle.
            // The controller action, and other middleware, will still execute, before this code is reached, 
            // if a check is not performed and handled respectively in the request lifecycle.
            if (!$result->isChecked()) {
                throw new BadRequestException('Recaptcha response has not been checked');
            }

            return $response;
        }

        return $handler->handle($request);
    }
}
