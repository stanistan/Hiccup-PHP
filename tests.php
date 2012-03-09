<?

// test hiccup

namespace Hiccup;

require 'src/Hiccup/Hiccup.php';

$tests = array(
	'generic' => array(
		array('p', 'text'),
		array('div#someid', 'text inside'),
		array('a', array(
			'href' => 'http://google.com'
		), 'link goes in here'),
		array( 'div#container', 
				array('div', 'inner text'),
				array('p', 'inner text'),
				array('ul', 
					array('li.first', 'item 1'),
					array('li', 'item 2', array(
						'weird-attr' => 'weird attr'
					))
				)
		),
		array('blockquote', 'sup'),
		array('a', array('span', 'hi'), array('strong', 'bold'), array('em', 'em'),
			array('href' => '#'))
	),
	'void elements' => array(
		array(
			'a', array('href' => 'http://google.com', 'style' => 'display:block'),
			array('img', array(
				'src' => 'https://www.google.com/images/srpr/logo3w.png',
				'alt' => 'Google',
				'title' => 'Google',
				'width' => 100
			))
		),
		array('br'),
		array('br'),
		array('p', 'more text', array('input', array(
			'type' => 'text', 'value' => 'default')))
	),
	'custom title' => array(
		array('div#custom', array('data-something' => 'words343423'), 'inner thing')
	)
);


foreach ($tests as $name => $t) {
	echo html('h1', $name);
	foreach ($t as $test) {
		echo html($test);			
	}
}
