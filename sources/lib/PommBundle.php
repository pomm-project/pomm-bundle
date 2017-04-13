<?php
/*
 * This file is part of the PommProject/PommBundle package.
 *
 * (c) 2014 Grégoire HUBERT <hubert.greg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PommProject\PommBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;

/**
 * PommBundle
 *
 * Pomm2 bundle class.
 *
 * @package PommBundle
 * @copyright 2014 Grégoire HUBERT
 * @author Nicolas JOSEPH
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see Bundle
 */
class PommBundle extends Bundle
{
    /**
     * build
     *
     * @see Bundle
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DependencyInjection\Compiler\ProfilerPass);
        $container->addCompilerPass(new DependencyInjection\Compiler\PoolerPass);
        $container->addCompilerPass(new DependencyInjection\Compiler\ModelPass);
    }

    /**
     * getContainerExtension
     *
     * @see Bundle
     */
    public function getContainerExtension()
    {
        return new DependencyInjection\PommExtension();
    }

    /**
     * @see Bundle
     */
    public function shutdown()
    {
        $this->container->get('pomm')->shutdown();
    }
}
