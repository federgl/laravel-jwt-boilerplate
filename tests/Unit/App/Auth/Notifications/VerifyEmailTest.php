<?php

declare(strict_types=1);

namespace Tests\Unit\App\Auth\Notifications;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class VerifyEmailTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class VerifyEmailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data provider for testToMail.
     *
     * @return array
     */
    public function providerToMail(): array
    {
    }

    /**
     * Data provider for testVerificationUrl.
     *
     * @return array
     */
    public function providerVerificationUrl(): array
    {
    }

    /**
     * @covers \App\Auth\Notifications\VerifyEmail::toMail
     */
    public function testToMail(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \App\Auth\Notifications\VerifyEmail::verificationUrl
     */
    public function testVerificationUrl(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
