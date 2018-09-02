<?php
namespace RdfDatatype\DataType;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Entity\Value;
use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

/**
 * @url https://www.w3.org/TR/xmlschema11-2/#gYear
 */
class XsdGYear extends AbstractRdfDatatype
{
    public function getName()
    {
        return 'xsd:gYear';
    }

    public function getLabel()
    {
        return 'Gregorian year'; // @translate
    }

    public function form(PhpRenderer $view)
    {
        $element = new Element\Number('xsd-g-year');
        $element->setAttributes([
            'class' => 'value to-require xsd-g-year',
            'data-value-key' => '@value',
            'placeholder' => 'Input a year with four digits: -0753', // @translate
        ]);
        return $view->formNumber($element);
    }

    public function isValid(array $valueObject)
    {
        if (!isset($valueObject['@value'])) {
            return false;
        }
        // Check with the offical regex from the w3c.
        // @url https://www.w3.org/TR/xmlschema11-2/#nt-gYearRep
        $value = preg_replace('/\s+/', '', $valueObject['@value']);
        return strlen($value)
            && preg_match(
                '/^-?([1-9][0-9]{3,}|0[0-9]{3})(Z|(\+|-)((0[0-9]|1[0-3]):[0-5][0-9]|14:00))?$/',
                $value
            );
    }

    public function hydrate(array $valueObject, Value $value, AbstractEntityAdapter $adapter)
    {
        $valueObject['@value'] = preg_replace('/\s+/', '', $valueObject['@value']);
        parent::hydrate($valueObject, $value, $adapter);
    }
}
