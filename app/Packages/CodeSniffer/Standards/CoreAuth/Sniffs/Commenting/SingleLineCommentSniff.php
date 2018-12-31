<?php

declare(strict_types=1);

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class CoreAuthSniffs_Commenting_SingleLineCommentSniff implements Sniff
{
    /**
     * @param \PHP_CodeSniffer\Files\File $resPhpCsFile
     * @param int                         $intStackPtr
     */
    public function process(File $resPhpCsFile, $intStackPtr): void
    {
        $arrmixTokens = $resPhpCsFile->getTokens();
        $strCurrentTokenContent = $arrmixTokens[$intStackPtr]['content'];

        // Ignore /* */ type of comments
        if ('//' !== \mb_substr($strCurrentTokenContent, 0, 2) && '#' !== \mb_substr($strCurrentTokenContent, 0, 1)) {
            return;
        }

        if (0 === \preg_match('/\/{2,}\s{1,}/', $strCurrentTokenContent)) {
            // Remove the multiple occurrences of // or # from start to show expected way of comment.
            $strExpectedContent = \preg_replace('/^(\/|#)+/', '', $strCurrentTokenContent);

            // Grab first few characters for showing correct way of commenting.
            $strExpectedContent = '// '.\mb_substr($strExpectedContent, 0, 20).'...';

            $strErrorMsg = 'Space required after the start of comment. '.PHP_EOL.'Expected: '.PHP_EOL.$strExpectedContent;
            $resPhpCsFile->addWarning(
                $strErrorMsg,
                $intStackPtr,
                'IncorrectSingleLineCommentStandard',
                [$strCurrentTokenContent]
            );

            return;
        }
    }

    /**
     * Returns an array of tokens this sniff will listen.
     *
     * @return array
     */
    public function register(): array
    {
        return [
            T_COMMENT, // Includes: // or #, and /* */
        ];
    }
}
