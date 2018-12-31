<?php

declare(strict_types=1);

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class CoreAuthSniffs_CodeAnalysis_DisallowInfiniteMemoryAllocationSniff.
 */
class CoreAuthSniffs_CodeAnalysis_DisallowInfiniteMemoryAllocationSniff implements Sniff
{
    /**
     * @param File $phpcsFile
     * @param int  $intStackPtr
     */
    public function process(File $phpcsFile, $intStackPtr): void
    {
        $arrmixTokens = $phpcsFile->getTokens();

        if ('ini_set' === $arrmixTokens[$intStackPtr]['content']) {
            $arrmixLines = \file($phpcsFile->getFilename());

            if (true === \preg_match(
                '/ini_set\(\s?[\'|\"]memory_limit[\'|\"],\s?[\'|\"]?-1[\'|\"]?\s?\)/',
                $arrmixLines[$arrmixTokens[$intStackPtr]['line'] - 1]
            )
            ) {
                $strError = 'Please specify fixed value while allocating memory for execution';
                $arrstrData = [\trim($arrmixTokens[$intStackPtr]['content'])];
                $phpcsFile->addWarning($strError, $intStackPtr, 'Found', $arrstrData);
            }
        }
    }

    /**
     * @return array
     */
    public function register(): array
    {
        return [T_STRING];
    }
}
