<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MX_Loader extends CI_Loader
{
    protected $_module;
    
    public $_ci_modules = array();
    public $_ci_models = array();
    
    public function __construct()
    {
        parent::__construct();
        
        $this->_ci_modules = array();
        $this->_ci_models = array();
    }
    
    public function initialize()
    {
        parent::initialize();
        $this->_module = CI::$APP->router->fetch_module();
    }
    
    public function _ci_load_class($class, $params = NULL, $object_name = NULL)
    {
        /* extend the modular loader */
        list($path, $_class) = Modules::find($class, $this->_module, 'libraries/');
        
        /* load library config file */
        if ($config = Modules::load_file($_class.'_config', $path, 'config'))
            $params = array_merge($params ?: array(), $config);
        
        return parent::_ci_load_class($_class, $params, $object_name, $path);
    }
    
    public function _ci_load_stock_library($library_name, $file_path, $params, $object_name)
    {
        if (isset($this->_ci_classes[$object_name]))
            return $this->_ci_classes[$object_name];
        
        return parent::_ci_load_stock_library($library_name, $file_path, $params, $object_name);
    }
    
    public function model($model, $object_name = NULL, $connect = FALSE)
    {
        if (is_array($model))
        {
            foreach ($model as $babe) $this->model($babe);
            return;
        }
        
        if ($model == '') return;
        
        if ($object_name == NULL)
        {
            $object_name = basename($model);
            if (strpos($object_name, '_') !== FALSE)
            {
                $object_name = str_replace('_', '', ucwords(str_replace('_', ' ', $object_name)));
            }
        }
        
        $object_name = strtolower($object_name);
        
        if (in_array($object_name, $this->_ci_models, TRUE))
            return;
        
        /* locate module model */
        if (list($path, $model) = Modules::find(strtolower($model), $this->_module, 'models/'))
        {
            if ($this->_ci_is_duplicate_model($model, $path))
                return;
            
            Modules::load_file($model, $path);
            
            $model = ucfirst($model);
            CI::$APP->$object_name = new $model();
            
            $this->_ci_models[] = $object_name;
            return;
        }
        
        /* check application models */
        parent::model($model, $object_name, $connect);
    }
    
    protected function _ci_is_duplicate_model($name, $path)
    {
        $name = strtolower($name);
        
        if (in_array($name, $this->_ci_models, TRUE))
            return TRUE;
        
        return FALSE;
    }
    
    public function module($module)
    {
        return Modules::load(array($module => $this->_module));
    }
}