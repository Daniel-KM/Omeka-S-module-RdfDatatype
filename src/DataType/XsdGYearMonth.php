<?php
namespace RdfDatatype\DataType;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Entity\Value;
use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

/**
 * @link https://www.w3.org/TR/xmlschema11-2/#gYearMonth
 */
class XsdGYearMonth extends AbstractRdfDatatype
{
    public function getName()
    {
        return 'xsd:gYearMonth';
    }

    public function getLabel()
    {
        return 'Gregorian year month'; // @translate
    }

    public function form(PhpRenderer $view)
    {
        $element = new Element\Text('xsd-g-year-month');
        $element->setAttributes([
            'class' => 'value to-require xsd-g-year-month',
            'data-value-key' => '@value',
            'placeholder' => 'Input a year and a month: 2018-09', // @translate
        ]);
        return $view->formText($element);
    }

    public function isValid(array $valueObject)
    {
        if (!isset($valueObject['@value'])) {
            return false;
        }
        // Check with the offical regex from the w3c.
        // @link https://www.w3.org/TR/xmlschema11-2/#nt-gYearMonthRep
        $value = preg_replace('/\s+/', '', $valueObject['@value']);
        return strlen($value)
            && preg_match(
                '/^-?([1-9][0-9]{3,}|0[0-9]{3})-(0[1-9]|1[0-2])(Z|(\+|-)((0[0-9]|1[0-3]):[0-5][0-9]|14:00))?$/',
                $value
            );
    }

    public function hydrate(array $valueObject, Value $value, AbstractEntityAdapter $adapter)
    {
        $valueObject['@value'] = preg_replace('/\s+/', '', $valueObject['@value']);
        parent::hydrate($valueObject, $value, $adapter);
    }
}
