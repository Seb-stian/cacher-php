<?php

require '../src/cacher.php';
Cacher::init();

Cacher::set('foo', '../test/foo.php');

Cacher::set_func('bar', 'generate_content', 'awesome');
function generate_content($args) {
    echo 'Content generated for the first time... ';
    return 'This is ' . $args[0] . '!';
}

// test/index.php?id=foo
// test/index.php?id=bar
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    Cacher::echo($_GET['id']);
}

?>