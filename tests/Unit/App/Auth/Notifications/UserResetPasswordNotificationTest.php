<?php

declare(strict_types=1);

namespace Tests\Unit\App\Auth\Notifications;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class UserResetPasswordNotificationTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class UserResetPasswordNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data provider for testConstruct.
     *
     * @return array
     */
    public function providerConstruct(): array
    {
    }

    /**
     * Data provider for testToMail.
     *
     * @return array
     */
    public function providerToMail(): array
    {
    }

    /**
     * Data provider for testVia.
     *
     * @return array
     */
    public function providerVia(): array
    {
    }

    /**
     * @covers \App\Auth\Notifications\UserResetPasswordNotification::__construct
     */
    public function testConstruct(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \App\Auth\Notifications\UserResetPasswordNotification::toMail
     */
    public function testToMail(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \App\Auth\Notifications\UserResetPasswordNotification::via
     */
    public function testVia(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
