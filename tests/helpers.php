<?php

require __DIR__ . '/../bootstrap.php';

class testHelpers extends PHPUnit_Framework_TestCase {

    public function testBasicDefhtml() {

        $basic = \Hiccup\Def::html('span');
        $this->assertEquals(
            $basic('foo'),
            '<span>foo</span>');

        $more = \Hiccup\Def::html('div#container', array('p', 'oh hi'));
        $this->assertEquals(
            $more(array('p#my-p', 'more')),
            '<div id="container"><p>oh hi</p><p id="my-p">more</p></div>');

    }

    public function testJS() {
        $this->assertEquals(
            \Hiccup\Element::javascriptTag("alert('hi');"),
            '<script type="text/javascript">alert(\'hi\');</script>');
    }

    public function testLinkTo() {
        $this->assertEquals(
            \Hiccup\Element::linkTo('/'),
            '<a href="/"></a>', 'no text');

        $this->assertEquals(
            \Hiccup\Element::linkTo('/', 'some'),
            '<a href="/">some</a>');

        $this->assertEquals(
            \Hiccup\Element::linkTo('/', 'some ', 'text'),
            '<a href="/">some text</a>');

        $this->assertEquals(
            \Hiccup\Element::linkTo('/', 'some ', array('img#img')),
            '<a href="/">some <img id="img" /></a>');
    }

    public function testMailTo() {
        $this->assertEquals(
            \Hiccup\Element::mailTo('foo@example.com'),
            '<a href="mailto:foo@example.com">foo@example.com</a>');

        $this->assertEquals(
            \Hiccup\Element::mailTo('foo@example.com', 'foo'),
            '<a href="mailto:foo@example.com">foo</a>');

        $this->assertEquals(
            \Hiccup\Element::mailTo('foo@example.com', 'Stan ', 'isTan'),
            \Hiccup\html('a', array('href' => 'mailto:foo@example.com'), 'Stan isTan'));
    }

    public function testLists() {

        $this->assertEquals(
            \Hiccup\Element::ol('foo', 'bar', 'baz'),
            \Hiccup\html('ol', array('li', 'foo'), array('li', 'bar'), array('li', 'baz')));

        $this->assertEquals(
            \Hiccup\Element::ul('foo', 'bar', 'baz'),
            \Hiccup\html('ul', array('li', 'foo'), array('li', 'bar'), array('li', 'baz')));

        $this->assertEquals(
            \Hiccup\Element::ul('hi', array('class' => 'sup')),
            '<ul class="sup"><li>hi</li></ul>');

    }

}
