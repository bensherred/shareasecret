<?php

namespace Tests\Domain\Secrets\Actions;

use Domain\Secrets\Actions\CreateSecretAction;
use Domain\Secrets\DataTransferObjects\SecretData;
use Domain\Secrets\Mail\SecretShared;
use Domain\Secrets\Models\Secret;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Domain\Shared\Models\User;
use Tests\TestCase;

class CreateSecretActionTest extends TestCase
{
    use WithFaker;

    public function test_it_creates_a_new_secret_without_an_email()
    {
        $secretData = new SecretData('secret', 300);

        $secret = (new CreateSecretAction())->execute($secretData);

        $this->assertInstanceOf(Secret::class, $secret);
        $this->assertDatabaseHas('secrets', [
            'ttl' => 300,
            'email' => null,
        ]);
    }

    public function test_it_can_create_a_secret_and_email_the_link()
    {
        Mail::fake();

        $user = User::factory()->create();
        $secretData = new SecretData('secret', 300, $email = $this->faker->safeEmail());

        $secret = (new CreateSecretAction())->execute($secretData, $user);

        $this->assertInstanceOf(Secret::class, $secret);
        $this->assertDatabaseHas('secrets', [
            'user_id' => $user->id,
            'ttl' => 300,
            'email' => $email,
        ]);

        Mail::assertQueued(SecretShared::class, function ($mail) use ($secret) {
            return $mail->hasTo($secret->email);
        });
    }

    public function test_it_does_not_store_the_email_if_a_user_is_not_provided()
    {
        Mail::fake();

        $secretData = new SecretData('secret', 300, $this->faker->safeEmail());

        $secret = (new CreateSecretAction())->execute($secretData);

        $this->assertInstanceOf(Secret::class, $secret);
        $this->assertDatabaseHas('secrets', [
            'ttl' => 300,
            'email' => null,
        ]);

        Mail::assertNothingSent();
    }
}
