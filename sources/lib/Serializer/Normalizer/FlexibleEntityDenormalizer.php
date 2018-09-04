<?php
/*
 * This file is part of the PommProject/PommBundle package.
 *
 * (c) 2018 Grégoire HUBERT <hubert.greg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PommProject\PommBundle\Serializer\Normalizer;

use PommProject\Foundation\Pomm;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Denormalizer for flexible entities.
 *
 * @package PommBundle
 * @copyright 2018 Grégoire HUBERT
 * @author Nicolas Joseph
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 */
class FlexibleEntityDenormalizer implements DenormalizerInterface
{
    private $pomm;

    public function __construct(Pomm $pomm)
    {
        $this->pomm = $pomm;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        if (isset($context['session:name'])) {
            $session = $this->pomm->getSession($context['session:name']);
        } else {
            $session = $this->pomm->getDefaultSession();
        }

        if (isset($context['model:name'])) {
            $model_name = $context['model:name'];
        } else {
            $model_name = "${class}Model";
        }

        $model = $session->getModel($model_name);
        return $model->createEntity($data);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        $reflection = new \ReflectionClass($type);
        $interfaces = $reflection->getInterfaces();

        // @TODO Use FlexibleEntityInterface::class with php >= 5.5
        return isset($interfaces['PommProject\ModelManager\Model\FlexibleEntity\FlexibleEntityInterface']);
    }
}
