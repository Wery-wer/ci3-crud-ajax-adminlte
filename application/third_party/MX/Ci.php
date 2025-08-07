<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* get the CI singleton */
global $CI;
if ( ! $CI) $CI = get_instance();

/* load the MX core classes */
if ( ! class_exists('CI', FALSE))
{
    class CI
    {
        public static $APP;
    }
}

CI::$APP = $CI;

/* create the application object */
require dirname(__FILE__).'/Base.php';