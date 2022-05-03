<?php

namespace Tests\Domain\Secrets\Jobs;

use Domain\Secrets\Jobs\DeleteExpiredSecretsJob;
use Domain\Secrets\Models\Secret;
use Tests\TestCase;

class DeleteExpiredSecretsJobTest extends TestCase
{
    public function test_it_deletes_expired_secrets()
    {
        Secret::factory()->create(['ttl' => 300]);

        $this->assertCount(1, Secret::all());

        $this->travel(10)->minutes();

        DeleteExpiredSecretsJob::dispatchSync();

        $this->assertEmpty(Secret::all());
    }

    public function test_it_does_not_delete_secrets_which_have_not_expired()
    {
        Secret::factory()->create(['ttl' => 300]);

        $this->assertCount(1, Secret::all());

        $this->travel(2)->minutes();

        DeleteExpiredSecretsJob::dispatchSync();

        $this->assertCount(1, Secret::all());
    }
}
