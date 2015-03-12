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

        return $reflection->isSubclassOf("\\PommProject\\ModelManager\\Model\\FlexibleEntity");
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $name = $configuration->getName();
        $options = $this->getOptions($configuration);

        $model = $this->pomm[$options['connection']]
            ->getModel('\\AppBundle\\Model\\ConfigModel');

        $entity = $model->findByPk($this->getPk($model, $request));

        $request->attributes->set($name, $entity);

        return true;
    }

    private function getOptions(ParamConverter $configuration)
    {
        return array_replace([
            'connection' => key(current($this->pomm)),
        ], $configuration->getOptions());
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
