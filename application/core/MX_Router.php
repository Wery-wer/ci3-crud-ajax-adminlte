<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MX_Router extends CI_Router
{
    public $module;
    
    public function fetch_module()
    {
        return $this->module;
    }
    
    protected function _validate_request($segments)
    {
        if (count($segments) == 0)
        {
            return $segments;
        }
        
        /* locate module controller */
        if ($located = $this->locate($segments)) return $located;
        
        /* use a default 404_override controller */
        if (isset($this->routes['404_override']) AND $this->routes['404_override'])
        {
            $segments = explode('/', $this->routes['404_override']);
            if ($located = $this->locate($segments)) return $located;
        }
        
        /* nothing found */
        show_404(implode('/', $segments));
    }
    
    public function locate($segments)
    {
        $this->module = '';
        $this->directory = '';
        
        /* use module route if available */
        if (isset($segments[0]) AND $routes = Modules::parse_routes($segments[0], implode('/', $segments)))
        {
            $segments = $routes;
        }
        
        /* get the segments array elements */
        list($module, $directory, $controller) = array_pad($segments, 3, NULL);
        
        foreach (Modules::$locations as $location => $offset)
        {
            /* module exists? */
            if (is_dir($source = $location.$module.'/controllers/'))
            {
                $this->module = $module;
                $this->directory = $offset.$module.'/controllers/';
                
                /* module sub-controller exists? */
                if ($directory)
                {
                    if (is_dir($source.$directory.'/'))
                    {
                        $source .= $directory.'/';
                        $this->directory .= $directory.'/';
                        
                        /* module sub-directory controller exists? */
                        if ($controller)
                        {
                            if (is_file($source.ucfirst($controller).'.php'))
                            {
                                return array_slice($segments, 2);
                            }
                            else $this->directory = $offset.$module.'/controllers/';
                        }
                    }
                    else
                    {
                        /* module controller exists? */
                        if (is_file($source.ucfirst($directory).'.php'))
                        {
                            return array_slice($segments, 1);
                        }
                    }
                }
                
                /* module default controller exists? */
                if (is_file($source.ucfirst($this->default_controller).'.php'))
                {
                    return array($this->default_controller);
                }
            }
        }
        
        /* application controller exists? */
        return array_slice($segments, 0);
    }
    
    public function set_class($class)
    {
        $this->class = $class.config_item('controller_suffix');
    }
}