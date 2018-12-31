<?php

declare(strict_types=1);

namespace Tests\Unit\App\Transformers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class UserTransformerTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class UserTransformerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data provider for testTransform.
     *
     * @return array
     */
    public function providerTransform(): array
    {
    }

    /**
     * @covers \App\Transformers\UserTransformer::transform
     */
    public function testTransform(): void
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
