<?php

namespace App\Domain\Secrets\Actions;

use App\Domain\Secrets\Models\Secret;

class DeleteSecretAction
{
    public function execute(Secret $secret): void
    {
        $secret->delete();
    }
}
