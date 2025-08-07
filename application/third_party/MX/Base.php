<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load MX core classes */
require_once dirname(__FILE__).'/Lang.php';
require_once dirname(__FILE__).'/Config.php';

class MX_Base extends CI_Controller
{
    public function __construct()
    {
        $class = str_replace(config_item('controller_suffix'), '', get_class($this));
        log_message('debug', $class." MX_Controller Initialized");
        Modules::$registry[strtolower($class)] = $this;
        
        /* copy a loader instance and initialize */
        $this->load = clone load_class('Loader', 'core');
        $this->load->initialize();
        
        /* autoload module items */
        $this->load->_autoloader(array());
    }
    
    public function __get($class)
    {
        return CI::$APP->$class;
    }
}