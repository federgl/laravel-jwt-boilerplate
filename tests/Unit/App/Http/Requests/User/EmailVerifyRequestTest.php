<?php

declare(strict_types=1);

namespace Tests\Unit\App\Http\Requests\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class EmailVerifyRequestTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class EmailVerifyRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data provider for testAll.
     *
     * @return array
     */
    public function providerAll(): array
    {
    }

    /**
     * Data provider for testAuthorize.
     *
     * @return array
     */
    public function providerAuthorize(): array
    {
    }

    /**
     * Data provider for testRules.
     *
     * @return array
     */
    public function providerRules(): array
    {
    }

    /**
     * @covers \App\Http\Requests\User\EmailVerifyRequest::all
     */
    public function testAll(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \App\Http\Requests\User\EmailVerifyRequest::authorize
     */
    public function testAuthorize(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \App\Http\Requests\User\EmailVerifyRequest::rules
     */
    public function testRules(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
