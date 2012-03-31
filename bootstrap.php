<?

require 'src/SplClassLoader.php';

$loader = new SplClassLoader(null, __DIR__ .'/src');
$loader->register();