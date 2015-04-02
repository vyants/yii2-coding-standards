<?php

/**
 * 
 */
class Yii2_Sniffs_PHP_NotCamelCaps extends PEAR_Sniffs_NamingConventions_ValidFunctionNameSniff
{
    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param int                  $stackPtr  The position in the stack where
     *                                        the token was found.
     *
     * @return void
     */
    public function processTokenOutsideScope(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $functionName = $phpcsFile->getDeclarationName($stackPtr);
        if ($functionName === null) {
            return;
        }
        $errorData = array($functionName);
        // Does this function claim to be magical?
        if (preg_match('|^__|', $functionName) !== 0) {
            $error = 'Function name "%s" is invalid; only PHP magic methods should be prefixed with a double underscore';
            $phpcsFile->addError($error, $stackPtr, 'DoubleUnderscore', $errorData);
            return;
        }
        if (PHP_CodeSniffer::isCamelCaps($functionName, false, true, false) === false) {
            if(!preg_match('~^get|set~', $functionName)) {
              $error = 'Function name "%s" is not in camel caps format';
              $phpcsFile->addError($error, $stackPtr, 'NotCamelCaps', $errorData);
            }
        }
    }//end process()
}
