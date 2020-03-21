# cacher-php

PHP script to cache your php files (or other stuff).

## How to:
---

How to cache PHP files:
```php
<?php

require 'cacher.php';
Cacher::init();

// cache PHP file
Cacher::set('foo', 'foo.php');

// show it
echo Cacher::get('foo');
// or...
Cacher::echo('foo');

?>
```

You can also use a callback:
```php
<?php

require 'cacher.php';
Cacher::init();

function generate_content($args) {
    return 'This is ' . $args[0] . '!';
}

Cacher::set_func('foo', 'generate_content', 'awesome');
Cacher::set_func('bar', 'generate_content', 'great');
Cacher::set_func('baz', 'generate_content', 'fantastic');

// this doesn't call the generate_content function, because 'foo' is already cached
Cacher::set_func('foo', 'generate_content', 'bad');

?>
```

Once you want to update your cache, you can manually remove the cache, or do this:
```php
<?php

require 'cacher.php';

// this removes cache named 'foo'
Cacher::remove('foo');

// this removes all cached files
Cacher::clear();

?>
```

## How it works:
---

**Cacher::init** creates a directory (called cache by default). Whenever you use **Cacher::set** or **Cacher::set_func**, it caches the result, unless it already exists. Using **Cacher::get** or **Cacher::echo** outputs the cached file or empty string if it doesn't exist. **Cacher::remove** removes specific cache, **Cacher::clear** removes all of it.

## My file doesn't cache!
---
Watch out for relative file paths. When you try caching file with a wrong path, it is simply ignored.