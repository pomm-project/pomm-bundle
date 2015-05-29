<?php
/*
 * This file is part of the PommProject/PommBundle package.
 *
 * (c) 2014 Grégoire HUBERT <hubert.greg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PommProject\PommBundle\Twig\Extension;

use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;

/**
 * ProfilerExtension
 *
 * Twig extension for Pomm2 profiler.
 *
 * @package PommBundle
 * @copyright 2014 Grégoire HUBERT
 * @author Nicolas JOSEPH
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see \Twig_Extension
 */
class ProfilerExtension extends \Twig_Extension
{
    /**
     * __construct
     *
     * Extension constructor.
     *
     * @access public
     * @param  FilesystemLoader $loader
     */
    public function __construct(FilesystemLoader $loader)
    {
        $loader->addPath($this->getTemplateDirectory(), 'Pomm');
    }

    /**
     * getTemplateDirectory
     *
     * Return the current package template directory.
     *
     * @access private
     * @return string
     */
    private function getTemplateDirectory()
    {
        $r = new \ReflectionClass('PommProject\\SymfonyBridge\\DatabaseDataCollector');

        return dirname(dirname(dirname($r->getFileName()))).'/views';
    }

    /**
     * getFilters
     *
     * @see \Twig_Extension
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('sql_format', function($sql) {

                return \SqlFormatter::format($sql);
            }),
        ];
    }

    /**
     * getName
     *
     * @see \Twig_Extension
     */
    public function getName()
    {
        return 'pomm';
    }
}
