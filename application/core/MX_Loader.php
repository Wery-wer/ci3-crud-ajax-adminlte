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
    
    public function _ci_load($_ci_data)
    {
        extract($_ci_data);
        
        if (isset($_ci_view))
        {
            $_ci_path = '';
            
            /* add file extension if not provided */
            $_ci_file = (pathinfo($_ci_view, PATHINFO_EXTENSION)) ? $_ci_view : $_ci_view.EXT;
            
            foreach ($this->_ci_view_paths as $path => $cascade)
            {
                if (file_exists($view_file = $path.$_ci_file))
                {
                    $_ci_path = $view_file;
                    break;
                }
                if ( ! $cascade) break;
            }
        }
        
        if ( ! isset($_ci_path) OR ! file_exists($_ci_path))
        {
            show_error('Unable to load the requested file: '.$_ci_file);
        }
        
        if (is_array($_ci_vars))
        {
            $this->_ci_cached_vars = array_merge($this->_ci_cached_vars, $_ci_vars);
        }
        extract($this->_ci_cached_vars);
        
        ob_start();
        
        if ((bool) @ini_get('short_open_tag') === FALSE AND config_item('rewrite_short_tags') == TRUE)
        {
            echo eval('?>'.preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?=', '<?php echo ', file_get_contents($_ci_path))));
        }
        else
        {
            include($_ci_path);
        }
        
        log_message('debug', 'File loaded: '.$_ci_path);
        
        if ($_ci_return == TRUE) return ob_get_clean();
        
        if (ob_get_level() > $this->_ci_ob_level + 1)
        {
            ob_end_flush();
        }
        else
        {
            $_ci_CI =& get_instance();
            $_ci_CI->output->append_output(ob_get_clean());
        }
    }
}