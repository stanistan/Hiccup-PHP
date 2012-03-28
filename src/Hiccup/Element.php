<?

namespace Hiccup\Element;

use \Hiccup;

class Element { 

}

function javascriptTag() {
	$args = func_get_args();
	$arr = array('script', array('type' => 'text/javascript'), implode("\n", $args));
	return Hiccup::html($arr);
}

function linkTo() {
	$args = func_get_args();
	$uri = array_shift($args);
	$anchor = array('a', array('href' => $uri));
	$args = array_merge($anchor, $args);
	return call_user_func_array('\Hiccup\html', $args);
}

function mailTo() {
	$args = func_get_args();
	$email = array_shift($args);
	if (!$args) $args = array($email);
	$anchor = array('a', array('href' => 'mailto:' . $email));
	$args = array_merge($anchor, $args);
	return call_user_func_array('\Hiccup\html', $args);
}

function ol() {
	$args = func_get_args();
	array_unshift($args, 'ol');
	return call_user_func_array('\Hiccup\Element\_list', $args);
}

function ul() {
	$args = func_get_args();
	array_unshift($args, 'ul');
	return call_user_func_array('\Hiccup\Element\_list', $args);
}

function _list() {
	$args = func_get_args();
	$tag = array_shift($args);
	$args = array_map(function($arr) use($tag) {
		return (is_array($arr))
			? (\Hiccup\is_assoc($arr) || !preg_match('/\bli\b/', $arr[0]))
				? $arr  : array_merge(array('li'), $arr)
			: array('li', $arr);
	}, $args);
	array_unshift($args, $tag);
	return call_user_func_array('\Hiccup\html', $args);

}