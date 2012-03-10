<?

require 'src/Hiccup/Hiccup.php';
require 'src/Hiccup/Def.php';
require 'src/Hiccup/Element.php';

function html() {
	$args = func_get_args();
	return call_user_func_array('\Hiccup\html', $args);
}