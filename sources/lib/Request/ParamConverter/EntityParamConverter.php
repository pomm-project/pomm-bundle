<?php

namespace PommProject\PommBundle\Request\ParamConverter;

use PommProject\Foundation\Pomm;
use PommProject\ModelManager\Model\Model;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;

class EntityParamConverter implements ParamConverterInterface
{
    private $pomm;

    public function __construct(Pomm $pomm)
    {
        $this->pomm = $pomm;
    }

    public function supports(ParamConverter $configuration)
    {
        if ($configuration->getClass() === null) {
            return false;
        }

        $reflection = new \ReflectionClass($configuration->getClass());

        return $reflection->implementsInterface("PommProject\\ModelManager\\Model\\FlexibleEntity\\FlexibleEntityInterface");
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $name = $configuration->getName();
        $options = $this->getOptions($configuration);

        $model = $options['session']->getModel($options['model']);

        try {
            $entity = $model->findByPk($this->getPk($model, $request));
        } catch (\LogicException $e) {
            if ($options["optional"] === false) {
                throw $e;
            }
        }

        $request->attributes->set($name, $entity);

        return true;
    }

    private function getOptions(ParamConverter $configuration)
    {
        $options = array_replace([
            'model' => $configuration->getClass() . 'Model',
        ], $configuration->getOptions());

        if (isset($options['connection'])) {
            $options['session'] = $this->pomm[$options['session']];
        }
        else {
            $options['session'] = $this->pomm->getDefaultSession();
        }

        $options["optional"] = $configuration->isOptional();

        return $options;
    }

    private function getPk(Model $model, Request $request)
    {
        $values = [];
        $primaryKeys = $model->getStructure()
            ->getPrimaryKey();

        foreach ($primaryKeys as $key) {
            if (!$request->attributes->has($key)) {
                throw new \LogicException("Missing primary key element '$key'");
            }
            $values[$key] = $request->attributes->get($key);
        }
        return $values;
    }
}
