<?php

/**
 * @author Sascha Bröning <sascha.broening@gmail.com>
 * @license LGPL-3.0
 * @copyright (c) 2014, Sascha Bröning
 * @version v 1.0 2014-08-28
 * @todo too much :)
 */
class ConsoleLog
{

    /**
     * Headline-View Style Sheet
     *
     * @var string
     */
    private $headline_format;

    /**
     * Variable-View Style Sheet
     *
     * @var string
     */
    private $var_format;

    /**
     * Type-View Style Sheet
     *
     * @var string
     */
    private $type_format;

    /**
     * Error-View Style Sheet
     *
     * @var string
     */
    private $error_format;

    /**
     * Called Class Container
     *
     * @var string
     */
    private $called_class;

    /**
     *
     * @method Constructor
     */
    public function __construct()
    {
        $this->headline_format = 'font-weight: bold; font-size: 16px';
        $this->var_format = 'background: #ECF2F5; color: #000; font-weight: bold';
        $this->type_format = 'background: #FFFFD7; color: #000; font-weight: bold';
        $this->error_format = 'background: #FFFFD7; color: #ff0000; font-weight: bold';
        
        $debug_array = debug_backtrace();
        $this->called_class = (isset($debug_array[1])) ? $debug_array[1]['class'] : $debug_array[0]['class'];
    }

    /**
     *
     * @method Create Headline Output
     * @param string $function            
     * @param int $line            
     * @return string $str
     */
    private function getOutputHead($function, $line)
    {
        $str = '<script>console.log("%c\r\nConsoleLog => ' . $function . ' - (Line:' . $line . ' / Call:' . $this->called_class . ')", "' . $this->headline_format . '")</script>';
        $str .= '<script>console.info("------------------------------------------------------------")</script>';
        return $str;
    }

    /**
     *
     * @method Create Body Output
     * @param string $type            
     * @param string $format            
     * @param string $data            
     * @return string $str
     */
    private function getOutputStr($type, $format, $data)
    {
        if (is_object($data)) {
            $str = '<script>console.log(' . json_encode($data) . ')</script>';
        } elseif (is_object(json_decode($data))) {
            $str = '<script>console.log(' . $data . ')</script>';
        } else {
            $str = '<script>console.log("%c[' . $type . ']", "' . $format . '",  " = ' . $data . '")</script>';
        }
        return $str;
    }

    /**
     *
     * @method Create Output As Object
     * @param mixed $data            
     * @return string $str
     */
    private function getOutputObj($data)
    {
        if (is_object($data) || is_array($data)) {
            $obj = json_encode($data);
            $str = '<script>';
            $str .= 'var object = \'' . str_replace("'", "\'", $obj) . '\';';
            $str .= 'var val = eval("(" + object + ")" );';
            $str .= 'console.dir(val);';
            $str .= '</script>';
            return $str;
        } elseif (is_object(json_decode($data))) {
            $str = '<script>console.log("%cJSON{}", "' . $this->var_format . '")</script>';
            $str .= '<script>console.log(JSON.stringify(' . $data . ', null, "\t"))</script>';
            return $str;
        } else {
            return '<script>console.warn("%c[' . gettype($data) . ']", "' . $this->error_format . '", "NO VALID OBJECT/ ARRAY/ JSON")</script>';
        }
    }

    /**
     *
     * @method Get/Set Data
     * @return boolean
     */
    public function log()
    {
        $debug_array = debug_backtrace();
        $arg_list = func_get_args();
        
        echo $this->getOutputHead($debug_array[0]['function'], $debug_array[0]['line']);
        foreach ($GLOBALS as $var_name => $value2) {
            foreach ($arg_list as $key => $value) {
                if ($value2 === $value) {
                    if (gettype($value) != 'array' && ! is_object($value) && ! is_object(json_decode($value))) {
                        $value = (is_string($value)) ? '\"' . $value . '\"' : $value;
                        echo '<script>console.log("%c$' . $var_name . '", "' . $this->var_format . '",  "= ' . $value . '")</script>';
                        unset($arg_list[$key]);
                    }
                }
            }
        }
        if (count($arg_list >= 1)) {
            foreach ($arg_list as $key => $value) {
                if ($value != '' || $value === false || $value === null) {
                    if ($value === false) {
                        echo $this->getOutputStr(gettype($value), $this->type_format, 'FALSE');
                    } elseif ($value === true) {
                        echo $this->getOutputStr(gettype($value), $this->type_format, 'TRUE');
                    } elseif ($value === null) {
                        echo $this->getOutputStr(gettype($value), $this->type_format, 'NULL');
                    } elseif (is_array($value)) {
                        echo $this->getOutputStr(gettype($value), $this->type_format, str_replace(array(
                            "\r\n",
                            "\r",
                            "\n"
                        ), '\n', print_r($value, true)));
                    } elseif (is_object($value)) {
                        echo $this->getOutputStr('', '', $value);
                    } elseif (is_object(json_decode($value))) {
                        echo $this->getOutputStr('', '', $value);
                    } else {
                        $value = (is_string($value)) ? '\"' . $value . '\"' : $value;
                        echo $this->getOutputStr(gettype($value), $this->type_format, $value);
                    }
                }
            }
        }
        return false;
    }

    /**
     *
     * @method Output Object
     */
    public function obj()
    {
        $debug_array = debug_backtrace();
        $arg_list = func_get_args();
        
        echo $this->getOutputHead($debug_array[0]['function'], $debug_array[0]['line']);
        
        foreach ($arg_list as $key => $value) {
            echo $this->getOutputObj($value);
        }
    }
}