<?php
declare(strict_types=1);

namespace RecaptchaV3\Service;

use Cake\Http\Client;
use Cake\Http\Exception\BadRequestException;
use Cake\Validation\Validator;
use InvalidArgumentException;

/**
 * RecaptchaV3 service for handling remote service calls
 */
class RecaptchaV3Service
{
    /**
     * @param string $secretKey The account secret key
     * @param string $siteKey The account client key
     */
    public function __construct(
        private readonly string $secretKey,
        private readonly string $siteKey,
    ) {
    }

    /**
     * Returns the secret key
     * 
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * Returns the site key
     * 
     * @return string
     */
    public function getSiteKey(): string
    {
        return $this->siteKey;
    }

    /**
     * Sends web request to the recaptcha service /siteverify endpoint
     * 
     * @param string $gRecaptchaResponse
     * @param string|null $remoteIp
     * @throws InvalidArgumentException If request payload failed validation
     * @throws BadRequestException If response from recaptcha service is not in the 2xx range
     * @return array
     */
    public function verifyRecaptchaResponse(string $gRecaptchaResponse, ?string $remoteIp = null): array
    {
        $data = [
            'secret' => $this->secretKey,
            'response' => $gRecaptchaResponse,
        ];

        if ($remoteIp !== null) {
            $data['remoteip'] = $remoteIp;
        }

        $validator = new Validator();

        $validator
            ->scalar('secret')
            ->requirePresence('secret')
            ->notEmptyString('secret');

        $validator
            ->scalar('response')
            ->requirePresence('response')
            ->notEmptyString('response');

        $validator
            ->ip('remoteip');

        $validationErrors = $validator->validate($data);
        
        if (!empty($validationErrors)) {
            throw new InvalidArgumentException('Recaptcha request body has validation errors');
        }

        $client = new Client();
        $response = $client->post(
            url: 'https://www.google.com/recaptcha/api/siteverify',
            data: $data,
        );
        
        if (!$response->isSuccess()) {
            $body = $response->getStringBody();
            throw new BadRequestException(sprintf('Recaptcha response: %s', $body));
        }

        return $response->getJson();
    }
}
