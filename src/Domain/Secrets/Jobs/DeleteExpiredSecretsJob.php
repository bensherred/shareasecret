<?php

namespace Domain\Secrets\Jobs;

use Domain\Secrets\Actions\DeleteSecretAction;
use Domain\Secrets\Models\Secret;
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
