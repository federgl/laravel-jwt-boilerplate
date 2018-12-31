<?php

declare(strict_types=1);

namespace Tests\Unit\App\Http\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class VerifyCsrfTokenTest.
 *
 * @requires PHP >= 7.2
 *
 * @internal
 *
 * @coversNothing
 */
final class VerifyCsrfTokenTest extends TestCase
{
    use RefreshDatabase;
}
