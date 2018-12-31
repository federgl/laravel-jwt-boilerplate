<?php

declare(strict_types=1);

use SlevomatCodingStandard\Sniffs\Namespaces\UnusedUsesSniff;

class CoreAuthSniffs_TypeHints_CustomUnusedUsesSniff extends UnusedUsesSniff
{
    public $searchAnnotations = true;
}
