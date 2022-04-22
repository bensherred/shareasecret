<?php

namespace App\Domain\Secrets\Jobs;

use App\Domain\Secrets\Actions\DeleteSecretAction;
use App\Domain\Secrets\Models\Secret;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteExpiredSecretsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle()
    {
        Secret::chunk(100, function ($secrets) {
            $secrets->each(function ($secret) {
                if ($secret->hasExpired()) {
                    (new DeleteSecretAction())->execute($secret);
                }
            });
        });
    }
}
