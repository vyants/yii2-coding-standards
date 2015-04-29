<?php

/**
 * 
 */
class Yii2_Sniffs_PHP_NotCamelCapsSniff implements  PHP_CodeSniffer_Sniff
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
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $functionName = $phpcsFile->getDeclarationName($stackPtr);
        if ($functionName === null) {
            return;
        }
        $errorData = array($functionName);
        if (PHP_CodeSniffer::isCamelCaps($functionName, false, true, false) === false) {
            if(!preg_match('~^get|set|__~', $functionName)) {
              $error = 'Function name "%s" is not in camel caps format';
              $phpcsFile->addError($error, $stackPtr, 'NotCamelCaps', $errorData);
            }
        }
    }//end process()

    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     */
    public function register()
    {
        return array(T_FUNCTION);
    }//end register()
}
