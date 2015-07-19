<?php

namespace LightCMS\CoreBundle\Util;

class ScalarUtil
{

    public function __get($name)
    {
        $name = strtolower($name);

        if (isset($this->$name)) {
            return $this->$name;
        }
        return null;
    }

    public function __set($name, $value)
    {
        $name = strtolower($name);
        $this->$name = $value;
    }

    public function __call ($name , $arguments)
    {
        $method = substr($name, 0, 3);
        $var = strtolower(substr($name, 3));

        if ($method == 'get') {
            if (isset($this->$var)) {
                return $this->$var;
            }
        } else if ($method == 'set') {
            $this->$var = $arguments[0];
            return true;
        }
        return null;
    }

}

?>