<?php
declare(strict_types=1);

namespace RecaptchaV3\Service;

use Cake\Http\Client;
use Cake\Http\Exception\HttpException;
use Cake\Http\Exception\InternalErrorException;
use Cake\Validation\Validator;
use RecaptchaV3\VerificationResult;

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
     * Performs validation on the generated recaptcha request payload
     * 
     * @param array $data
     * @return array
     */
    private function validateRequestData(array $data)
    {
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

        return $validator->validate($data);
    }

    /**
     * Sends web request to the recaptcha service /siteverify endpoint
     * 
     * @param string $gRecaptchaResponse
     * @param string|null $remoteIp
     * @throws InternalErrorException If generated request payload failed validation
     * @return VerificationResult
     */
    public function verifyRecaptchaResponse(string $gRecaptchaResponse, ?string $remoteIp = null): VerificationResult
    {
        $data = [
            'secret' => $this->secretKey,
            'response' => $gRecaptchaResponse,
        ];

        if ($remoteIp !== null) {
            $data['remoteip'] = $remoteIp;
        }

        $validationErrors = $this->validateRequestData($data);
        
        if (!empty($validationErrors)) {
            throw new InternalErrorException('Recaptcha request body has validation errors');
        }

        $client = new Client();
        $response = $client->post(
            url: 'https://www.google.com/recaptcha/api/siteverify',
            data: $data,
        );
        
        if (!$response->isSuccess()) {
            $body = $response->getStringBody();
            throw new HttpException(sprintf('Recaptcha response: %s', $body));
        }

        return new VerificationResult($response->getJson());
    }
}