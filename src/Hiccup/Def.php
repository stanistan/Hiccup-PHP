<?php

namespace Hiccup;

/**
 *  @author Stan Rozenraukh
 */
class Def {

    /**
     *  @return string
     */
    public static function html()
    {
        $args = func_get_args();
        return function() use($args) {
            $in_args = func_get_args();
            $total_args = array_merge($args, $in_args);
            return call_user_func_array(array('\Hiccup\Hiccup', 'html'), $total_args);
        };
    }

}
