<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MX_Controller
{
    public function __autoload($class)
    {
        if (substr($class, -10) == 'Controller')
        {
            $name = substr($class, 0, -10);
        }
        else $name = $class;
        
        if (is_file($location = APPPATH.'controllers/'.ucfirst($name).'.php'))
        {
            include_once $location;
            return $this;
        }
        
        /* autoload module items */
        foreach (Modules::$locations as $path => $offset)
        {
            if (is_file($location = $path.ucfirst($name).'.php') OR
                is_file($location = $path.'controllers/'.ucfirst($name).'.php'))
            {
                include_once $location;
                return $this;
            }
        }
        
        /* autoload library items */
        return parent::__autoload($class);
    }
}

/* load the MX core module class */
require dirname(__FILE__).'/Modules.php';