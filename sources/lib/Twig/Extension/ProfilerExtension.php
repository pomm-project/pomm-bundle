<?php

namespace PommProject\PommBundle\Twig\Extension;

use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;

class ProfilerExtension extends \Twig_Extension
{
    public function __construct(FilesystemLoader $loader)
    {
        $loader->addPath($this->getTemplateDirectory(), 'Pomm');
    }

    private function getTemplateDirectory()
    {
        $r = new \ReflectionClass('PommProject\\SymfonyBridge\\DatabaseDataCollector');
        return dirname(dirname(dirname($r->getFileName()))).'/views';
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('sql_format', function($sql) {
                return \SqlFormatter::format($sql);
            }),
        ];
    }

    public function getName()
    {
        return 'pomm';
    }
}
