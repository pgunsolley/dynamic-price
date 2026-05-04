<?php
declare(strict_types=1);

namespace RecaptchaV3\Service;

use Cake\Http\Client;
use Cake\Http\Exception\HttpException;

class RecaptchaV3Service
{
    public function __construct(private string $secretKey, private string $siteKey)
    {
    }

    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    public function getSiteKey(): string
    {
        return $this->siteKey;
    }

    public function verifyRecaptchaResponse(string $gRecaptchaResponse): array
    {
        $client = new Client();
        $response = $client->post(
            url: 'https://www.google.com/recaptcha/api/siteverify',
            data: [
                'secret' => $this->secretKey,
                'response' => $gRecaptchaResponse,
            ],
        );
        
        if (!$response->isSuccess()) {
            $body = $response->getStringBody();
            throw new HttpException(sprintf('Recaptcha response: %s', $body));
        }

        return json_decode($response->getJson(), true);
    }
}