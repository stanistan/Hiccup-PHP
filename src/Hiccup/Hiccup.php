<?

namespace Hiccup;

function html() {
	$args = func_get_args();
	$num_args = func_num_args();
	return (is_string($args[0]))
		? _render($args)
		: array_reduce($args, function($text, $arg) {
			return $text . ((is_array($arg[0]))
				? html($arg)
				: _render($arg));
		 });
}

function _tagAttributes($attrs) {
	$text = '';
	foreach ($attrs as $k => $v) {
		$text .= sprintf(' %s="%s"', $k, htmlentities($v));
	}
	return $text;
}

function _removeFirstLetter($str) {
	return substr($str, 1);
}

function _getVoidEls() {
	return array(
		'area', 'base', 'br', 'col', 'command', 'embed', 'hr', 'img', 'input', 'keygen',
		'link', 'meta', 'param', 'source', 'track', 'wbr'
	);
}

function _isVoidElement($tag) {
	return (in_array($tag, _getVoidEls()));
}

function _getSelfClosing() {
	return array(
		'text', 'p', 'xml'
	);
}

function _isSelfClosing($tag) {
	return (in_array($tag, _getSelfClosing()));
}

function _getMatches($tag) {
	$pattern = '/(.|#){0,1}\w+/i';
	preg_match_all($pattern, $tag, $matches);
	return $matches[0];
}

function is_assoc($arr) {
	if (!is_array($arr)) return false;
	return (count(array_filter(array_keys($arr), 'is_string')) == count($arr));
}

function _prep($arr) {

	$tag = array_shift($arr);
	$attrs = array();
	$subs = array();

	$patterns = array(
		'/#/' 	=>  function($m) use(&$attrs) { $attrs['id'] = $m; }, 	
		'/\./'	=>	function($m) use(&$attrs) { $attrs['class'] .= ' ' . $m; } 	
	);

	foreach (_getMatches($tag) as $match) {
		if (!$match) continue;
		foreach (array_keys($patterns) as $pattern) {
			if (preg_match($pattern, $match)) {
				$patterns[$pattern](_removeFirstLetter($match));
				continue 2;
			}
		}
		$tag = $match;
	}

	foreach ($arr as $piece) {
		if (is_assoc($piece)) $attrs = array_merge($attrs, $piece);
		else $subs[] = $piece;
	}

	return array(
		'tag' => strtolower($tag),
		'attrs' => array_map('trim', $attrs),
		'subs' => $subs
	);

}

function _innerHTML($subs) {
	return array_reduce($subs, function($all, $sub) {
		return $all . ( (is_array($sub) )  ? _render($sub)  : $sub );
	});
}

function _render($arr) {
	$pr = (object) _prep($arr);
	$spr = array($pr->tag, _tagAttributes($pr->attrs));
	if (_isVoidElement($pr->tag) || (!$pr->subs && _isSelfClosing($pr->tag))) {
		return vsprintf('<%s%s />', $spr);
	}
	$spr = array_merge($spr, array(_innerHTML($pr->subs), $pr->tag));
	return vsprintf('<%s%s>%s</%s>', $spr);
}

