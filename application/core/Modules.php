<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

global $CFG;

/* get module locations from config settings or use the default location and offset */
$locations = isset($CFG) ? $CFG->item('modules_locations') : NULL;

Modules::$locations = $locations ? $locations : array(
    APPPATH.'modules/' => '../modules/',
);

/* PHP5 spl_autoload */
spl_autoload_register('Modules::autoload');

class Modules
{
    public static $locations;
    public static $registry;
    
    /**
     * Load a module controller
     */
    public static function load($module)
    {
        (is_array($module)) ? list($module, $params) = each($module) : $params = NULL;
        
        /* get the requested controller */
        $alias = strtolower(basename($module));
        $controller = ucfirst($alias);
        
        /* create or return an existing controller from the registry */
        if ( ! isset(self::$registry[$alias]))
        {
            /* find the controller */
            list($class) = CI::$APP->router->locate(explode('/', $module));
            
            /* controller cannot be located */
            if (empty($class))
                return;
            
            /* set the module directory */
            $path = APPPATH.'controllers/'.CI::$APP->router->directory;
            
            /* load the controller class */
            $class = $class.config_item('controller_suffix');
            self::load_file($class, $path);
            
            /* create and register the new controller */
            $controller = ucfirst($class);
            self::$registry[$alias] = new $controller($params);
        }
        
        return self::$registry[$alias];
    }
    
    /** 
     * Library base class autoload
     */
    public static function autoload($class)
    {
        /* don't autoload CI_ prefixed classes or those using the config subclass_prefix */
        if (strstr($class, 'CI_') OR strstr($class, config_item('subclass_prefix')))
            return;
        
        /* autoload Modular Extensions MX core classes */
        if (strstr($class, 'MX_') AND is_file($location = dirname(__FILE__).'/'.substr($class, 3).'.php'))
        {
            include_once $location;
            return;
        }
        
        /* autoload core classes */
        if (is_file($location = APPPATH.'core/'.$class.'.php'))
        {
            include_once $location;
            return;
        }
        
        /* autoload library classes */
        if (is_file($location = APPPATH.'libraries/'.$class.'.php'))
        {
            include_once $location;
            return;
        }
    }
    
    /** 
     * Load a module file
     */
    public static function load_file($file, $path, $type = 'other', $result = TRUE)
    {
        $file = str_replace('.php', '', $file);
        $location = $path.$file.'.php';
        
        if ($type === 'other')
        {
            if (class_exists($file, FALSE))
            {
                log_message('debug', "File already loaded: {$location}");
                return $result;
            }
            include_once $location;
        }
        else
        {
            /* load multiple files of the same name */
            if ($result != TRUE)
                $result = array();
            
            if (glob($path.'*/'.$file.'.php'))
            {
                foreach (glob($path.'*/'.$file.'.php') as $f)
                {
                    include_once $f;
                    $result[] = basename($f, '.php');
                }
            }
            else
            {
                if (is_file($location))
                {
                    include_once $location;
                    $result = basename($location, '.php');
                }
            }
        }
        
        log_message('debug', "File loaded: {$location}");
        return $result;
    }
    
    /**
     * Parse module routes
     */
    public static function parse_routes($module, $uri)
    {
        /* load the route file */
        if ( ! isset(self::$routes[$module]))
        {
            if (list($path) = Modules::find('routes', $module, 'config/') AND $path)
                self::$routes[$module] = Modules::load_file('routes', $path, 'config');
        }
        
        if ( ! isset(self::$routes[$module]))
            return;
        
        /* parse module routes */
        foreach (self::$routes[$module] as $key => $val)
        {
            
            $key = str_replace(array(':any', ':num'), array('.+', '[0-9]+'), $key);
            
            if (preg_match('#^'.$key.'$#', $uri))
            {
                if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE)
                {
                    $val = preg_replace('#^'.$key.'$#', $val, $uri);
                }
                return explode('/', $module.'/'.$val);
            }
        }
    }
    
    /** 
     * Find a file
     */
    public static function find($file, $module, $base = NULL)
    {
        $segments = explode('/', $file);
        
        $file = array_pop($segments);
        $path = ltrim(implode('/', $segments).'/', '/');
        
        foreach (Modules::$locations as $location => $offset)
        {
            $source = $location.$module.'/'.$base.$path;
            
            if ($base)
            {
                /* load base file */
                if (is_file($source.$file.'.php'))
                {
                    return array($source, $file);
                }
            }
            else
            {
                /* load app file */
                if (is_file($source.$file.'.php'))
                {
                    return array($source, $file);
                }
                
                /* load module file */
                if (is_file($application = APPPATH.$path.$file.'.php'))
                {
                    return array(APPPATH.$path, $file);
                }
            }
        }
        
        return array(FALSE, $file);
    }
}

/* create a common CI SuperObject to function as the APPPATH/third_party/MX/Ci.php file */
class CI extends MX_Loader {}