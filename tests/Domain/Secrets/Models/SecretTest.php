<?php

namespace Tests\Domain\Secrets\Models;

use Domain\Secrets\Models\Secret;
use Tests\TestCase;

class SecretTest extends TestCase
{
    public function test_it_can_determine_if_a_secret_has_expired()
    {
        $secret = Secret::factory()->create(['ttl' => 300]);

        $this->assertFalse($secret->hasExpired());

        $this->travel(10)->minutes();

        $this->assertTrue($secret->hasExpired());
    }
}
