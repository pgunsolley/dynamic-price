<?php
declare(strict_types=1);

namespace App\Service;

use Firebase\JWT\JWT;
use App\Model\Entity\User;
use App\Service\Jwt\Payload;
use Firebase\JWT\Key;

class JwtService
{
    public function __construct(private string $algorithm, private string $key, private ?string $publicKey = null)
    {
    }

    public function encode(User $user, ?int $expiration = null, array $additionalClaims = []): string
    {
        return JWT::encode(
            payload: [
                'iss' => 'dynamic-price',
                'sub' => $user->id,
                'exp' => $expiration ?? time() + (60 * 60),
            ] + $additionalClaims,
            key: $this->key,
            alg: $this->algorithm,
        );
    }

    public function decode(string $jwt)
    {
        return JWT::decode($jwt, new Key($this->publicKey ?? $this->key, $this->algorithm));
    }

    public function decodePayload(string $jwt): Payload
    {
        return new Payload($this->decode($jwt));
    }
}