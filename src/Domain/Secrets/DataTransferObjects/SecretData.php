<?php

namespace Domain\Secrets\DataTransferObjects;

class SecretData
{
    public function __construct(
        public readonly string $value,
        public readonly int $ttl,
        public readonly ?string $email = null
    ) {
    }
}
