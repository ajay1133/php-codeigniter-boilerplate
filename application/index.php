<?php
/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 */
define('ENVIRONMENT', 'development');
/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 */
if (defined('ENVIRONMENT'))
{
    switch (ENVIRONMENT)
    {
        case 'development':
            // Report all errors
            error_reporting(E_ALL);

            // Display errors in output
            ini_set('display_errors', 1);
        break;

        case 'testing':
        case 'production':
            // Report all errors except E_NOTICE
            // This is the default value set in php.ini
            error_reporting(E_ALL ^ E_NOTICE);

            // Don't display errors (they can still be logged)
            ini_set('display_errors', 1);
        break;

        default:
            exit('The application environment is not set correctly.');
    }
}
?>