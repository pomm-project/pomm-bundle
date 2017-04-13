<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/** @var ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';

/** @see https://github.com/doctrine/annotations/issues/103 */
AnnotationRegistry::registerLoader('class_exists');
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;
