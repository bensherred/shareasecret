<?php

namespace Domain\Secrets\Actions;

use Domain\Secrets\Models\Secret;

class DeleteSecretAction
{
    public function execute(Secret $secret): void
    {
        $secret->delete();
    }
}
