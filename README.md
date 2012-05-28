# Hiccup-PHP #

Port of [Hiccup for Clojure](https://github.com/weavejester/hiccup) to PHP.

### Examples #

Why not use short array syntax? (Obviously it works with normal array syntax.)

```php

<?php

// this will include the file so that we can automatically just use the helper funciton \Hiccup\html
new \Hiccup\Hiccup;

\Hiccup\html('p'); 
// <p></p>

\Hiccup\html('p', 'some text');
\Hiccup\html(
  ['p', 'some text']
);

// <p>some text</p>
// <p>some text</p>

\Hiccup\html(
  'div#container',
  ['p', 'text',
    ['ul', 
      ['li', 'item 1'],
      ['li', 'item 2']
    ]
  ]
);

/*
  <div id="container">
    <p>text</p>
    <ul>
      <li>item 1</li>
      <li>item 2</li>
    </ul>
  </div>
*/

?>
```

Can create any kind of tag, as well as add any kind of attribute:

```php
<?php

\Hiccup\html('some-tag', 
  ['my-attr' => 'any attr'],
  ['div#asdf', ['inner-attr' => 'something_else'], 'text']
);

/*
  <some-tag my-attr="any attr">
    <div id="asdf" inner-attr="something_else">
      text
    </div>
  </some-tag>

*/
?>
```

#### Note: #

These are no line breaks / indentation in the generated HTML, it isn't prettily formatted.

Run the test to see the output.

Maybe will add this in the future.
