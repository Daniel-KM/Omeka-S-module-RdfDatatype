<?php
namespace RdfDatatype\DataType;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Entity\Value;
use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

/**
 * @link https://www.w3.org/TR/xmlschema11-2/#gMonth
 */
class XsdGMonth extends AbstractRdfDatatype
{
    public function getName()
    {
        return 'xsd:gMonth';
    }

    public function getLabel()
    {
        return 'Gregorian month'; // @translate
    }

    public function form(PhpRenderer $view)
    {
        $element = new Element\Text('xsd-g-month');
        $element->setAttributes([
            'class' => 'value to-require xsd-g-month',
            'data-value-key' => '@value',
            'placeholder' => 'Input a month normalized as rdf: --09', // @translate
        ]);
        return $view->formText($element);
    }

    public function isValid(array $valueObject)
    {
        if (!isset($valueObject['@value'])) {
            return false;
        }
        // Check with the offical regex from the w3c.
        // @link https://www.w3.org/TR/xmlschema11-2/#nt-gMonthRep
        $value = preg_replace('/\s+/', '', $valueObject['@value']);
        return strlen($value)
            && preg_match(
                '/^--(0[1-9]|1[0-2])(Z|(\+|-)((0[0-9]|1[0-3]):[0-5][0-9]|14:00))?$/',
                $value
            );
    }

    public function hydrate(array $valueObject, Value $value, AbstractEntityAdapter $adapter)
    {
        $valueObject['@value'] = preg_replace('/\s+/', '', $valueObject['@value']);
        parent::hydrate($valueObject, $value, $adapter);
    }
}
