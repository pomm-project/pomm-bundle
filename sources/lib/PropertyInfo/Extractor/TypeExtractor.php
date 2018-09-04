<?php
/*
 * This file is part of the PommProject/PommBundle package.
 *
 * (c) 2018 Grégoire HUBERT <hubert.greg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PommProject\PommBundle\PropertyInfo\Extractor;

use PommProject\Foundation\Pomm;
use PommProject\Foundation\Session;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\PropertyInfo\Type;

/**
 * Extract data using pomm.
 *
 * @package PommBundle
 * @copyright 2018 Grégoire HUBERT
 * @author Nicolas Joseph
 * @license X11 {@link http://opensource.org/licenses/mit-license.php}
 */
class TypeExtractor implements PropertyTypeExtractorInterface
{
    private $pomm;

    public function __construct(Pomm $pomm)
    {
        $this->pomm = $pomm;
    }

    /**
     * @see PropertyTypeExtractorInterface
     */
    public function getTypes($class, $property, array $context = array())
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

        if (!class_exists($model_name)) {
            return;
        }

        $sql_type = $this->getSqlType($session, $model_name, $property);
        $pomm_type = $this->getPommType($session, $sql_type);

        return [
            $this->createPropertyType($pomm_type)
        ];
    }

    /**
     * Get the sql type of $property
     *
     * @return string
     */
    private function getSqlType(Session $session, $model_name, $property)
    {
        $model = $session->getModel($model_name);
        $structure = $model->getStructure();

        return $structure->getTypeFor($property);
    }

    /**
     * Get the corresponding php type of a $sql_type type
     *
     * @return string
     */
    private function getPommType(Session $session, $sql_type)
    {
        $pomm_types = $session->getPoolerForType('converter')
            ->getConverterHolder()
            ->getTypesWithConverterName();

        if (!isset($pomm_types[$sql_type])) {
            throw new \RuntimeException("Invalid $sql_type");
        }

        return $pomm_types[$sql_type];
    }

    /**
     * Create a new Type for the $pomm_type type
     *
     * @return Type
     */
    private function createPropertyType($pomm_type)
    {
        $class = null;
        $nullable = false;

        switch ($pomm_type) {
            case 'Array':
                $type = Type::BUILTIN_TYPE_ARRAY;
                break;
            case 'String':
                $type = Type::BUILTIN_TYPE_STRING;
                break;
            case 'Boolean':
                $type = Type::BUILTIN_TYPE_BOOL;
                break;
            case 'Number':
                $type = Type::BUILTIN_TYPE_INT;
                break;
            case 'JSON':
                $type = Type::BUILTIN_TYPE_ARRAY;
                break;
            case 'Binary':
                $type = Type::BUILTIN_TYPE_STRING;
                break;
            case 'Timestamp':
                $type = Type::BUILTIN_TYPE_OBJECT;
                $name = 'DateTime';
                break;
            case 'Interval':
                $type = Type::BUILTIN_TYPE_OBJECT;
                $name = 'DateInterval';
                break;
            case 'Point':
                $type = Type::BUILTIN_TYPE_OBJECT;
                $name = 'PommProject\Foundation\Converter\Type\Point';
                break;
            case 'Circle':
                $type = Type::BUILTIN_TYPE_OBJECT;
                $name = 'PommProject\Foundation\Converter\Type\Circle';
                break;
            case 'NumberRange':
                $type = Type::BUILTIN_TYPE_OBJECT;
                $name = 'PommProject\Foundation\Converter\Type\NumRange';
                break;
            case 'TsRange':
                $type = Type::BUILTIN_TYPE_OBJECT;
                $name = 'PommProject\Foundation\Converter\Type\TsRange';
                break;
            default:
                $type = Type::BUILTIN_TYPE_OBJECT;
                $name = $pomm_type;
                break;
        }

        return new Type($type, $nullable, $class);
    }
}
