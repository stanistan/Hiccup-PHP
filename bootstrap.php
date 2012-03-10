<?

require 'src/Hiccup/Hiccup.php';

function html() {
	$args = func_get_args();
	return call_user_func_array('\Hiccup\html', $args);
}