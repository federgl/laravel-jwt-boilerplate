<?php

declare(strict_types=1);

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     */
    public function testBasicExample(): void
    {
        $this->browse(static function (Browser $browser): void {
            $browser->visit('/')
                ->assertSee('Laravel');
        });
    }
}
