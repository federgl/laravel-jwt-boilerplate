<?php

declare(strict_types=1);

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class CoreAuthSniffs_CodeAnalysis_ProhibitMagicNumberComparisonSniff.
 */
class CoreAuthSniffs_CodeAnalysis_ProhibitMagicNumberComparisonSniff implements Sniff
{
    /**
     * @param File $resPhpCsFile
     * @param int  $intStackPtr
     */
    public function process(File $resPhpCsFile, $intStackPtr): void
    {
        $arrmixTokens = $resPhpCsFile->getTokens();

        if ('if' === $arrmixTokens[$intStackPtr]['content'] || 'else if' === $arrmixTokens[$intStackPtr]['content']) {
            $strContent = $resPhpCsFile->getTokensAsString(
                $arrmixTokens[$intStackPtr]['parenthesis_opener'] + 1,
                $arrmixTokens[$intStackPtr]['parenthesis_closer'] - $arrmixTokens[$intStackPtr]['parenthesis_opener']
            );

            if (1 === \preg_match('/(.*)(1|0)(\s)==(\s)\$this->m_bool(.*)/', $strContent) || 1 === \preg_match(
                '/(.*)(1|0)(\s)==(\s)\$bool(.*)/',
                $strContent
            ) || 1 === \preg_match(
                '/(.*)(1|0)(\s)===(\s)\$this->m_bool(.*)/',
                $strContent
            ) || 1 === \preg_match('/(.*)(1|0)(\s)===(\s)\$bool(.*)/', $strContent)
            ) {
                $strError = 'Magic number used for boolean variable comparison. Use only true/false.';
                $resPhpCsFile->addError($strError, $intStackPtr, 'MagicNumberComparison');
            }
        }
    }

    /**
     * @return array
     */
    public function register(): array
    {
        return [
            T_IF,
            T_ELSEIF,
        ];
    }
}
