<?php

namespace Hiccup;

/**
 *  @author Stan Rozenraukh
 */
class Hiccup
{

    /**
     *  @var array
     */
    private static $void_elements = array(
        'area',
        'base',
        'br',
        'col',
        'command',
        'embed',
        'hr',
        'img',
        'input',
        'keygen',
        'link',
        'meta',
        'param',
        'source',
        'track',
        'wbr'
    );

    /**
     *  @var array
     */
    private static $self_closing_elements = array(
        'text',
        'p',
        'xml'
    );

    /**
     *  @param mixed
     *  @return str parsed HTML
     */
    public static function html()
    {
        $args = func_get_args();
        $num_args = func_num_args();
        return (is_string($args[0]))
            ? self::render($args)
            : array_reduce($args, function($text, $arg) {
                return $text . ((is_array($arg[0]))
                    ? Hiccup::html($arg)
                    : Hiccup::render($arg));
             });
    }

    /**
     *  returns html string formatted by self::prep($arr)
     *  @param  array $arr
     *  @return string
     */
    public static function render(array $arr)
    {
        # get prepped
        $pr = (object) self::prep($arr);
        $tag = $pr->tag;
        $subs = $pr->subs;

        # set up array for sprintf
        $spr = array(
            $pr->tag,
            self::tagAttributes($pr->attrs)
        );

        $formats = array(
            '<%s%s>%s</%s>',        # normal
            '<%s%s />'              # self closing or void element
        );

        # get format index
        $index = (self::isVoidElement($tag) || (!$subs && self::isSelfClosing($tag)));
        if (!$index) {
            $spr = array_merge($spr, array(
                self::innerHTML($subs),
                $tag)
            );
        }

        return vsprintf($formats[$index], $spr);
    }

    /**
     *  @param  array $subs
     *  @return string
     */
    public static function innerHTML(array $subs)
    {
        return array_reduce($subs, function($all, $sub) {
            return $all . ( (is_array($sub) )  ? Hiccup::render($sub)  : $sub );
        });
    }

    /**
     *  @param  array $attrs
     *  @return string
     */
    public static function tagAttributes(array $attrs)
    {
        $text = '';
        foreach ($attrs as $k => $v) {
            $text .= sprintf(' %s="%s"', $k, htmlentities($v));
        }
        return $text;
    }

    /**
     *  @param  string $str
     *  @return string
     */
    public static function removeFirstLetter($str)
    {
        return substr($str, 1);
    }

    /**
     *  @return array
     */
    public static function getVoidElements()
    {
        return self::$void_elements;
    }

    /**
     *  @param  string  $tag
     *  @return Boolean
     */
    public static function isVoidElement($tag)
    {
        return (in_array($tag, self::getVoidElements()));
    }

    /**
     *  @return array
     */
    public static function getSelfClosing()
    {
        return self::$self_closing_elements;
    }

    public static function isSelfClosing($tag)
    {
        return (in_array($tag, self::getSelfClosing()));
    }

    /**
     *  returns an array of matches to tagname#id.class
     *  @param  string  $tag
     *  @return array
     */
    public static function getMatches($tag)
    {
        $pattern = '/(.|#){0,1}[\w-]+/i';
        preg_match_all($pattern, $tag, $matches);
        return array_filter($matches[0]);
    }

    /**
     *  @param  array   $arr
     *  @return Boolean
     */
    public static function isAssoc($arr)
    {
        if (!is_array($arr)) return false;
        return (count(array_filter(array_keys($arr), 'is_string')) == count($arr));
    }

    /**
     *  @param  mixed   $arg
     *  @return Boolean
     */
    public static function isClosure($arg)
    {
        return (is_object($arg) && is_callable($arg));
    }

    /**
     *  @param  array   $arr
     *  @return array           associative array to help with structuring output
     */
    public static function prep(array $arr)
    {
        $tag = array_shift($arr);
        $attrs = array();
        $subs = array();

        $patterns = array(
            '/#/'   =>  function($m) use(&$attrs) { $attrs['id'] = $m; },
            '/\./'  =>  function($m) use(&$attrs) { $attrs['class'] .= ' ' . $m; }
        );

        $filter_nulls = function($r) {
            return (!is_null($r));
        };

        $ms = self::getMatches($tag);
        foreach ($ms as $m) {
            foreach ($patterns as $pattern => $fn) {
                if (!preg_match($pattern, $m)) continue;
                $fn(self::removeFirstLetter($m));
                continue 2;
            }
            $tag = $m;
        }

        if (!$tag) {
            throw new \InvalidArgumentException('No tag could be generated');
        }

        foreach ($arr as $piece) {
            if (self::isAssoc($piece)) {
                $attrs = array_merge($attrs, $piece);
            } else {
                $subs[] = $piece;
            }
        }

        # check booleans
        array_walk($attrs, function(&$val, $key) {
            $val = (is_bool($val) || is_null($val))
                ? ((!$val) ? null : $key)
                : trim($val);
        });

        # remove null values
        $attrs = array_filter($attrs, $filter_nulls);

        return array(
            'tag' => strtolower($tag),
            'attrs' => $attrs,
            'subs' => $subs
        );
    }

}

function html() {
    return call_user_func_array(array('\Hiccup\Hiccup', 'html'), func_get_args());
}
