<?php

namespace Domain\Secrets\Actions;

use Domain\Secrets\DataTransferObjects\SecretData;
use Domain\Secrets\Mail\SecretShared;
use Domain\Secrets\Models\Secret;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Domain\Shared\Models\User;

class CreateSecretAction
{
    public function execute(SecretData $secretData, ?User $user = null): Secret
    {
        $secret =  Secret::create([
            'user_id' => $user?->id,
            'uuid' => (string) Str::uuid(),
            'value' => encrypt($secretData->value),
            'ttl' => $secretData->ttl,
            'email' => $user && $secretData->email ? $secretData->email : null,
        ]);

        if ($secret->email) {
            Mail::to($secret->email)->queue(new SecretShared($secret));
        }

        return $secret;
    }
}
