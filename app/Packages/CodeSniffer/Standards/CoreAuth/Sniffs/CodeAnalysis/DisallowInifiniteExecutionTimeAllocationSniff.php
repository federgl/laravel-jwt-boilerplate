<?php

declare(strict_types=1);

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class CoreAuthSniffs_CodeAnalysis_DisallowInifiniteExecutionTimeAllocationSniff.
 */
class CoreAuthSniffs_CodeAnalysis_DisallowInifiniteExecutionTimeAllocationSniff implements Sniff
{
    /**
     * @param File $phpcsFile
     * @param int  $intStackPtr
     */
    public function process(File $phpcsFile, $intStackPtr): void
    {
        $arrmixTokens = $phpcsFile->getTokens();

        if ('ini_set' === $arrmixTokens[$intStackPtr]['content'] || 'set_time_limit' === $arrmixTokens[$intStackPtr]['content']) {
            $arrmixLines = \file($phpcsFile->getFilename());

            if (true === \preg_match(
                '/ini_set\(\s?[\'|\"]max_execution_time[\'|\"],\s?[\'|\"]?0[\'|\"]?\s?\)/',
                $arrmixLines[$arrmixTokens[$intStackPtr]['line'] - 1]
            ) || true === \preg_match(
                '/set_time_limit\(\s?0\s?\)/',
                $arrmixLines[$arrmixTokens[$intStackPtr]['line'] - 1]
            )
            ) {
                $strError = 'Please specify fixed value while specifying execution time';
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
