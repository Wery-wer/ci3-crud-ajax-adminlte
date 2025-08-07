<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MX_Lang extends CI_Lang
{
    public function load($langfile, $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '', $_module = '')
    {
        if (is_array($langfile)) return $this->load($langfile);
        
        $deft_lang = CI::$APP->config->item('language');
        $idiom = ($idiom == '') ? $deft_lang : $idiom;
        
        if (in_array($langfile.'_lang.php', $this->is_loaded, TRUE))
            return $this->language;
        
        $_module OR $_module = CI::$APP->router->fetch_module();
        list($path, $_langfile) = Modules::find($langfile.'_lang', $_module, 'language/'.$idiom.'/');
        
        if ($path === FALSE)
        {
            if ($lang = parent::load($langfile, $idiom, $return, $add_suffix, $alt_path))
                return $lang;
        }
        else
        {
            if ($lang = Modules::load_file($_langfile, $path, 'lang'))
            {
                if ($return) return $lang;
                $this->language = array_merge($this->language, $lang);
                $this->is_loaded[] = $langfile.'_lang.php';
                unset($lang);
            }
        }
        
        return $this->language;
    }
}