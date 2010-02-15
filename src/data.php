<?php
namespace ComplexPie;

class Data extends Extension
{
    protected static $static_ext = array();
    
    public static function add_static_extension($extpoint, $ext, $priority)
    {
        if ($extpoint === 'get' && !is_callable($ext))
        {
            throw new \InvalidArgumentException("$ext is not callable");
        }
        parent::add_static_extension($extpoint, $ext, $priority);
    }
    
    public function add_extension($extpoint, $ext, $priority)
    {
        if ($extpoint === 'get' && !is_callable($ext))
        {
            throw new \InvalidArgumentException("$ext is not callable");
        }
        parent::add_extension($extpoint, $ext, $priority);
    }
    
    public function __get($name)
    {
        $return = array();
        foreach ($this->get_extensions('get') as $extension)
        {
            if (($extreturn = $extension($this->dom, $name)) !== null)
            {
                if (is_array($extreturn))
                {
                    $return = array_merge_recursive($extreturn, $return);
                }
                elseif (!$return)
                {
                    return $extreturn;
                }
            }
        }
        if ($return)
        {
            return $return;
        }
        
        if (method_exists($this, "get_$name"))
        {
            return call_user_func(array($this, "get_$name"));
        }
    }
}

Data::add_static_extension_point('get');
