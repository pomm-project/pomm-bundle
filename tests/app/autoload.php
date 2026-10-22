<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/** @var ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';

/** @see https://github.com/doctrine/annotations/issues/103 */
// doctrine/annotations 2.x removed registerLoader() and autoloads by itself
if (method_exists(AnnotationRegistry::class, 'registerLoader')) {
    AnnotationRegistry::registerLoader('class_exists');
    AnnotationRegistry::registerLoader([$loader, 'loadClass']);
}

return $loader;
