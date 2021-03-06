<?php

declare(strict_types=1);

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class HomePage extends Page
{
    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser
     */
    public function assert(Browser $browser): void
    {
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements(): array
    {
        return [
            '@element' => '#selector',
        ];
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url(): string
    {
        return '/';
    }
}
