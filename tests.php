<?

// test hiccup

require 'src/Hiccup/Hiccup.php';

$tests = array(
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
);

foreach ($tests as $t) {

	echo PHP_EOL . '-----------------------' . PHP_EOL;
	echo Hiccup::render($t);

}

echo PHP_EOL . '-------------- ALL -------------------' . PHP_EOL;
// give it a container
array_unshift($tests, 'div#enttirety');
echo Hiccup::render($tests);