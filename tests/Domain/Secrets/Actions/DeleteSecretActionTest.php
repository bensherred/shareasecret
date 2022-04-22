<?php

namespace Tests\Domain\Secrets\Actions;

use App\Domain\Secrets\Actions\DeleteSecretAction;
use App\Domain\Secrets\Models\Secret;
use Tests\TestCase;

class DeleteSecretActionTest extends TestCase
{
    public function test_it_deletes_a_secret()
    {
        $secret = Secret::factory()->create();

        $this->assertCount(1, Secret::all());

        (new DeleteSecretAction())->execute($secret);

        $this->assertEmpty(Secret::all());
    }
}
