<?php

declare(strict_types=1);

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;

/**
 * Class CoreAuthSniffs_Naming_ValidVariableNameSniff.
 */
class CoreAuthSniffs_NamingConventions_ValidVariableNameSniff extends AbstractVariableSniff
{
    /**
     * @var array
     */
    public $supportedTokenizers = ['PHP'];

    /**
     * @param File $resPhpCsFile
     * @param int  $intStackPtr
     */
    protected function processMemberVar(File $resPhpCsFile, $intStackPtr): void
    {
        $arrmixTokens = $resPhpCsFile->getTokens();

        $arrmixMemberProps = $resPhpCsFile->getMemberProperties($intStackPtr);
        $strMemberName = \ltrim($arrmixTokens[$intStackPtr]['content'], '$');

        if (true === empty($arrmixMemberProps)) {
            return;
        }
    }

    /**
     * @param File $resPhpCsFile
     * @param int  $intStackPtr
     */
    protected function processVariable(File $resPhpCsFile, $intStackPtr): void
    {
        // We don't care about normal variables.
        $arrmixTokens = $resPhpCsFile->getTokens();

        $strOriginalVariableName = \ltrim($arrmixTokens[$intStackPtr]['content']);
        $strVariableName = \ltrim($strOriginalVariableName, '$');

        $arrstrReservedVars = [
            '_SERVER',
            '_GET',
            '_POST',
            '_REQUEST',
            '_SESSION',
            '_ENV',
            '_COOKIE',
            '_FILES',
            'GLOBALS',
            'http_response_header',
            'HTTP_RAW_POST_DATA',
            'php_errormsg',
            'this',
            '_objException',
        ];

        if (true === \in_array($strVariableName, $arrstrReservedVars, true)) {
            return;
        }

        if (T_DOUBLE_COLON === $arrmixTokens[$intStackPtr - 1]['code']) {
            return;
        }

        if (0 === \preg_match('/[a-zA-Z0-9]/', $strVariableName)) {
            $strErrorMsg = 'PHP Variables "%s" cannot have special characters';
            $resPhpCsFile->addWarning(
                $strErrorMsg,
                $intStackPtr,
                'NoSpecialCharaters',
                [$strOriginalVariableName]
            );

            return;
        }

        if (0 === \preg_match(
            '/^(int|flt|dbl|str|obj|bool|mix|res|arrint|arrflt|arrdbl|arrstr|arrobj|arrbool|arrmix|arrres|callable|_REQUEST_FORM_)[A-Z]/',
            $strVariableName,
            $arrmixMatches
        )
        ) {
            $strErrorMsg = 'Variable "%s" must contain valid prefix followed by capital character. One of the prefix should be used. int|flt|dbl|str|obj|bool|mix|res|arrint|arrflt|arrdbl|arrstr|arrobj|arrbool|arrmix|arrres|callable';
            $resPhpCsFile->addError(
                $strErrorMsg,
                $intStackPtr,
                'IncorrectVariablePrefix',
                [$strOriginalVariableName]
            );

            return;
        }

        if (\count(
            $arrmixTokens
        ) > $intStackPtr + 4 && ('T_CONSTANT_ENCAPSED_STRING' === $arrmixTokens[$intStackPtr + 4]['type']) && ('T_EQUAL' === $arrmixTokens[$intStackPtr + 2]['type']) && ('str' !== \mb_substr(
            $strVariableName,
            0,
            3
        ))
        ) {
            $strErrorMsg = 'String value is assigned to variable "%s", so variable name must start with "$str" instead of "$%s". Either correct the assignment or correct the variable name.';
            $resPhpCsFile->addWarning(
                $strErrorMsg,
                $intStackPtr,
                'IncorrectVariablePrefix',
                [$strOriginalVariableName, $arrmixMatches[1]]
            );
        }

        if ('T_OPEN_SQUARE_BRACKET' === $arrmixTokens[$intStackPtr + 1]['type'] && ('arr' !== \mb_substr(
            $strVariableName,
            0,
            3
        )) && ('str' !== \mb_substr($strVariableName, 0, 3)) && 0 === \preg_match(
            '/obj.*Container/',
            $strVariableName
        )
        ) {
            $strErrorMsg = 'Variable "%s" seems to be used as array, so variable name must start with "$arr".';
            $resPhpCsFile->addWarning(
                $strErrorMsg,
                $intStackPtr,
                'IncorrectVariablePrefix',
                [$strOriginalVariableName, $arrmixMatches[1]]
            );
        }

        if (\count(
            $arrmixTokens
        ) > $intStackPtr + 4 && ('T_TRUE' === $arrmixTokens[$intStackPtr + 4]['type'] || 'T_FALSE' === $arrmixTokens[$intStackPtr + 4]['type']) && ('T_EQUAL' === $arrmixTokens[$intStackPtr + 2]['type']) && ('bool' !== \mb_substr(
            $strVariableName,
            0,
            4
        ))
        ) {
            $strErrorMsg = 'Variable "%s" has been assigned a boolean value, so variable name must start with "$bool" instead of "$%s".';
            $resPhpCsFile->addWarning(
                $strErrorMsg,
                $intStackPtr,
                'IncorrectVariablePrefix',
                [$strOriginalVariableName, $arrmixMatches[1]]
            );
        }

        if (('T_OPEN_SQUARE_BRACKET' === $arrmixTokens[$intStackPtr + 1]['type']) && ('T_EQUAL' === $arrmixTokens[$intStackPtr + 5]['type']) && ('T_CONSTANT_ENCAPSED_STRING' === $arrmixTokens[$intStackPtr + 7]['type'])) {
            if (('arrstr' !== \mb_substr($strVariableName, 0, 6)) && ('arrmix' !== \mb_substr(
                $strVariableName,
                0,
                6
            ))
            ) {
                $strErrorMsg = 'Variable "%s" seems to be used for array of strings, so variable name must start with "$arrstr" or "$arrmix" instead of "$%s".';
                $resPhpCsFile->addWarning(
                    $strErrorMsg,
                    $intStackPtr,
                    'IncorrectVariablePrefix',
                    [$strOriginalVariableName, $arrmixMatches[1]]
                );
            }
        }
    }

    /**
     * @param File $resPhpCsFile
     * @param int  $intStackPtr
     */
    protected function processVariableInString(File $resPhpCsFile, $intStackPtr): void
    {
        // We don't care about normal variables.
    }
}
