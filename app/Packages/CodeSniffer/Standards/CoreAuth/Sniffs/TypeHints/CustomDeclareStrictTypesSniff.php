<?php

declare(strict_types=1);

use SlevomatCodingStandard\Sniffs\TypeHints\DeclareStrictTypesSniff;

class CoreAuthSniffs_TypeHints_CustomDeclareStrictTypesSniff extends DeclareStrictTypesSniff
{
    public $newlinesCountBetweenOpenTagAndDeclare = 2;
    public $spacesCountAroundEqualsSign = 0;
}
