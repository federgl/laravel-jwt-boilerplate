<?php

declare(strict_types=1);

namespace Tests\Unit\App\Mail;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class VerifyUserMailTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class VerifyUserMailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data provider for testBuild.
     *
     * @return array
     */
    public function providerBuild(): array
    {
    }

    /**
     * Data provider for testConstruct.
     *
     * @return array
     */
    public function providerConstruct(): array
    {
    }

    /**
     * @covers \App\Mail\VerifyUserMail::build
     */
    public function testBuild(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \App\Mail\VerifyUserMail::__construct
     */
    public function testConstruct(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
