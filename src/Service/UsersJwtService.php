<?php
declare(strict_types=1);

namespace App\Service;

use Firebase\JWT\JWT;
use App\Model\Entity\User;
use Firebase\JWT\Key;
use InvalidArgumentException;

class UsersJwtService
{
    public function __construct(private string $privateKey, private string $publicKey, private string $algorithm)
    {
    }

    public function encode(User $user, ?int $expirationSeconds = null): string
    {
        return JWT::encode([
            'iss' => 'dynamic-price',
            'sub' => $user->id,
            'exp' => $expirationSeconds ?? time() + (60 * 60 * 72),
        ], $this->privateKey, $this->algorithm);
    }

    public function decode(string $jwt): array
    {
        return (array)JWT::decode($jwt, new Key($this->publicKey, $this->algorithm));
    }

    public function extractUserId(string $jwt): mixed
    {
        $decoded = $this->decode($jwt);

        if (!array_key_exists('sub', $decoded)) {
            throw new InvalidArgumentException('Decoded JWT is missing sub');
        }

        return $decoded['sub'];
    }
}