<?

class Hiccup {

	public static function render() {
		
		$args = func_get_args();
		$num_args = func_num_args();

		if (is_string($args[0])) {
			return self::make($args);
		}

		return array_reduce($args, function($text, $arg) {
			return $text . ((is_array($arg[0]))
				? Hiccup::render($arg)
				: Hiccup::make($arg));
		});

	}

	public static function is_assoc($arr) {
		if (!is_array($arr)) return false;
		return (count(array_filter(array_keys($arr), 'is_string')) == count($arr));
	}

	public static function innerTag($inner) {
		$text = '';
		foreach ($inner as $k => $v) {
			$text .= sprintf(' %s="%s"', $k, htmlentities($v) );
		}
		return $text;
	}

	public static function prep($arr) {

		$remove_first = function($str) { return substr($str, 1); };

		$tag = strtolower(array_shift($arr));
		$properties = array();
		$children = array();

		preg_match_all('/(.|#){0,1}\w+/i', $tag, $matches);			
		foreach ($matches[0] as $m) {
			if (preg_match('/#/', $m)) {
				$properties['id'] = $remove_first($m);
			} else if (preg_match('/\./', $m)) {
				$properties['class'] .= ' ' . $remove_first($m);
			} else if ($m) {
				$tag = $m;
			}
		}

		foreach ($arr as $v) {
			if (self::is_assoc($v)) {
				$properties = array_merge($properties, $v);
			} else {
				$children[] = $v;
			}
		}

		return array(
			'tag' => $tag,
			'properties' => array_map('trim', $properties),
			'children' => $children
		);

	}

	public static function innerHTML($children) {
		return array_reduce($children, function($whole, $child) {
			$child = (is_array($child)) ? Hiccup::make($child) : $child;
			return $whole . $child;
		});
	}

	public static function make($arr) {
		$prepped = self::prep($arr);
		return vsprintf('<%s%s>%s</%s>', array(
			$prepped['tag'],
			self::innerTag($prepped['properties']),
			self::innerHTML($prepped['children']),
			$prepped['tag']
		));
	}

}
