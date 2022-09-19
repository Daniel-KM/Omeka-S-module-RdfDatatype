<?php
namespace RdfDatatype\DataType;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Entity\Value;
use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

/**
 * @link https://www.w3.org/TR/xmlschema11-2/#gDay
 */
class XsdGDay extends AbstractRdfDatatype
{
    public function getName()
    {
        return 'xsd:gDay';
    }

    public function getLabel()
    {
        return 'Gregorian day'; // @translate
    }

    public function form(PhpRenderer $view)
    {
        $element = new Element\Text('xsd-g-day');
        $element->setAttributes([
            'class' => 'value to-require xsd-g-day',
            'data-value-key' => '@value',
            'placeholder' => 'Input a day normalized as rdf: ---07', // @translate
        ]);
        return $view->formText($element);
    }

    public function isValid(array $valueObject)
    {
        if (!isset($valueObject['@value'])) {
            return false;
        }
        // Check with the offical regex from the w3c.
        // @link https://www.w3.org/TR/xmlschema11-2/#nt-gDayRep
        $value = preg_replace('/\s+/', '', $valueObject['@value']);
        return strlen($value)
            && preg_match(
                '/^---(0[1-9]|[12][0-9]|3[01])(Z|(\+|-)((0[0-9]|1[0-3]):[0-5][0-9]|14:00))?$/',
                $value
            );
    }

    public function hydrate(array $valueObject, Value $value, AbstractEntityAdapter $adapter)
    {
        $valueObject['@value'] = preg_replace('/\s+/', '', $valueObject['@value']);
        parent::hydrate($valueObject, $value, $adapter);
    }
}
