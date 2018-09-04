<?php
/*
 * This file is part of the PommProject/PommBundle package.
 *
 * (c) 2015 Grégoire HUBERT <hubert.greg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PommProject\PommBundle\PropertyInfo\Extractor;

@trigger_error('The '.__NAMESPACE__.'\PommExtractor class is deprecated since version 2.3 and will be removed in 3.0. Use the '.__NAMESPACE__.'\TypeExtractor class instead.', E_USER_DEPRECATED);

class_alias(__NAMESPACE__ . '\TypeExtractor', __NAMESPACE__ . '\PommExtractor');
