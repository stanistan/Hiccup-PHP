<?php

require __DIR__ . '/src/SplClassLoader.php';

$loader = new SplClassLoader('Hiccup', __DIR__ .'/src');
$loader->register();
