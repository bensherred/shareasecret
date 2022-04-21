<?php

namespace App\Domain\Secrets\Actions;

use App\Domain\Secrets\DataTransferObjects\SecretData;
use App\Domain\Secrets\Mail\SecretShared;
use App\Domain\Secrets\Models\Secret;
use App\Domain\Shared\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
