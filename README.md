# Hiccup-PHP #

Port of [Hiccup for Clojure](https://github.com/weavejester/hiccup) to PHP.

### Examples #

Why not use short array syntax? (Obviously it works with normal array syntax.)

```php

<?php

namespace Hiccup;

html('p'); 
// <p></p>

html('p', 'some text');
html(
  ['p', 'some text']
);

// <p>some text</p>
// <p>some text</p>

html(
  'div#container',
  [ 'p', 'text',
    [ 'ul', 
      [ 'li', 'item 1'],
      [ 'li', 'item 2']
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

html('some-tag', 
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
