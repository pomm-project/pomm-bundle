<?php
/*
 * This file is part of the PommProject/PommBundle package.
 *
 * (c) 2014 - 2016 Grégoire HUBERT <hubert.greg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PommProject\PommBundle\Model;

/**
 * PommExtension
 *
 * DIC extension
 *
 * @package   PommBundle
 * @copyright 2016 Grégoire HUBERT
 * @author    Miha Vrhovnik
 * @license   X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see       Extension
 */
interface ServiceMapInterface
{
    /**
     * Add mapping between model and a service
     *
     * @param string $class
     * @param string $serviceId
     */
    public function addModelToServiceMapping($class, $serviceId);
}
