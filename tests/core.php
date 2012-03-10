<?

require __DIR__ . '/../bootstrap.php';

class testCore extends PHPUnit_Framework_TestCase {
	
	public function testBasicTags() {
		$this->assertEquals(
			html('div'), 
			'<div></div>');

		$this->assertEquals(
			html(array('div')),
			html('div'));
	}  

	public function testSyntaxSugar() {
		$this->assertEquals(
			html('div#foo'), 
			'<div id="foo"></div>');

		$this->assertEquals(
			html('div.foo'),
			 '<div class="foo"></div>');

		$this->assertEquals(
			html('div.foo', 'bar', 'baz'),
			'<div class="foo">barbaz</div>');

		$this->assertEquals(
			html('div.a.b'), 
			'<div class="a b"></div>');

		$this->assertEquals(
			html('div.a.b.c'), 
			'<div class="a b c"></div>');

		$this->assertEquals(
			html('div#foo.bar.baz'), 
			'<div id="foo" class="bar baz"></div>');
	}

	public function testEmptyTags() {
		$this->assertEquals(
			html('div'), 
			'<div></div>');

		$this->assertEquals(
			html('h1'),
			'<h1></h1>');

		$this->assertEquals(
			html('script'), 
			'<script></script>');

		$this->assertEquals(
			html('text'), 
			'<text />');

		$this->assertEquals(
			html('a'), 
			'<a></a>');

		$this->assertEquals(
			html('iframe'), 
			'<iframe></iframe>');
	}

	public function testTagContents() {
		$this->assertEquals(
			html('text', 'Lorem Ipsum'), 
			'<text>Lorem Ipsum</text>');

		$this->assertEquals(
			html('body', 'foo', 'bar'), 
			'<body>foobar</body>');

		$this->assertEquals(
			html('body', array('p'), array('br')), 
			'<body><p /><br /></body>');

		$this->assertEquals(
			html('body', array('p', 'a'), array('p', 'b')), 
			'<body><p>a</p><p>b</p></body>');

		$this->assertEquals(
			html('p', array('span', array('a', 'foo'))),
			'<p><span><a>foo</a></span></p>');
	}

	public function testAttributes() {
		$this->assertEquals(
			html('xml', array()), 
			'<xml />');

		$this->assertEquals(
			html('xml', array('a' => 1, 'b' => 2)),
			'<xml a="1" b="2" />');



	}


}
