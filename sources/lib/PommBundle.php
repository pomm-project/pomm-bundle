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
     * getContainerExtension
     *
     * @see Bundle
     */
    public function getContainerExtension()
    {
        return new DependencyInjection\PommExtension();
    }
}
