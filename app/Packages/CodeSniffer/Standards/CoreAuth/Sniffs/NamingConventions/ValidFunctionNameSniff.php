<?php

declare(strict_types=1);

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\AbstractScopeSniff;
use PHP_CodeSniffer\Util\Common;

/**
 * Class CoreAuthSniffs_Naming_ValidFunctionNameSniff.
 */
class CoreAuthSniffs_NamingConventions_ValidFunctionNameSniff extends AbstractScopeSniff
{
    /**
     * @var array
     */
    protected $magicFunctions = ['autoload'];
    /**
     * @var array
     */
    protected $magicMethods = [
        'construct',
        'destruct',
        'call',
        'callStatic',
        'get',
        'set',
        'isset',
        'unset',
        'sleep',
        'wakeup',
        'toString',
        'set_state',
        'clone',
        'invoke',
    ];

    /**
     * CoreAuthSniffs_Naming_ValidFunctionNameSniff constructor.
     */
    public function __construct()
    {
        parent::__construct([T_CLASS, T_INTERFACE], [T_FUNCTION], true);
    }

    /**
     * @param File $phpcsFile
     * @param int  $stackPtr
     */
    protected function processTokenOutsideScope(File $phpcsFile, $stackPtr): void
    {
        $functionName = $phpcsFile->getDeclarationName($stackPtr);
        if (null === $functionName) {
            return;
        }

        $errorData = [$functionName];

        if (0 !== \preg_match('|^__|', $functionName)) {
            $magicPart = \mb_substr($functionName, 2);
            if (false === \in_array($magicPart, $this->magicFunctions, true)) {
                $error = 'Function name "%s" is invalid; only PHP magic methods should be prefixed with a double underscore';
                $phpcsFile->addError($error, $stackPtr, 'FunctionDoubleUnderscore', $errorData);
            }

            return;
        }

        // Method must not have an underscore on the front.
        if ('_' === $functionName[0]) {
            $error = '%s method name "%s" must not be prefixed with an underscore';
            $data = [
                $functionName,
                $errorData[0],
            ];
            $phpcsFile->addError($error, $stackPtr, 'MethodUnderscore', $data);

            return;
        }

        if (false === Common::isCamelCaps($functionName, false, true, false)) {
            $error = 'Method name "%s" is not in camel caps format. Function name should start with small case letter and must not contain any special character.';
            $phpcsFile->addError($error, $stackPtr, 'NotCamelCaps', $errorData);

            return;
        }
    }

    /**
     * @param File $phpcsFile
     * @param int  $stackPtr
     * @param int  $currScope
     */
    protected function processTokenWithinScope(File $phpcsFile, $stackPtr, $currScope): void
    {
        $methodName = $phpcsFile->getDeclarationName($stackPtr);
        if (null === $methodName) {
            // Ignore closures.
            return;
        }

        $className = $phpcsFile->getDeclarationName($currScope);
        $errorData = [$className.'::'.$methodName];

        // Is this a magic method. IE. is prefixed with "__".
        if (0 !== \preg_match('|^__|', $methodName)) {
            $magicPart = \mb_substr($methodName, 2);
            if (false === \in_array($magicPart, $this->magicMethods, true)) {
                $error = 'Method name "%s" is invalid; only PHP magic methods should be prefixed with a double underscore';

                $phpcsFile->addError($error, $stackPtr, 'MethodDoubleUnderscore', $errorData);
            }

            return;
        }

        // PHP4 constructors are allowed to break our rules.
        if ($methodName === $className) {
            return;
        }

        // PHP4 destructors are allowed to break our rules.
        if ($methodName === '_'.$className) {
            return;
        }

        $methodProps = $phpcsFile->getMethodProperties($stackPtr);
        $scope = $methodProps['scope'];

        // Method must not have an underscore on the front.
        if ('_' === $methodName[0]) {
            $error = '%s method name "%s" must not be prefixed with an underscore';
            $data = [
                \ucfirst($scope),
                $errorData[0],
            ];
            $phpcsFile->addError($error, $stackPtr, 'MethodUnderscore', $data);

            return;
        }

        if (false === Common::isCamelCaps($methodName, false, true, false)) {
            $error = 'Method name "%s" is not in camel caps format. Function name should start with small case letter and must not contain any special character.';
            $phpcsFile->addError($error, $stackPtr, 'NotCamelCaps', $errorData);

            return;
        }
    }
}
