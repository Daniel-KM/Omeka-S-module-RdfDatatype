<?php
namespace RdfDatatype\DataType;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Entity\Value;
use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

/**
 * @link https://www.w3.org/TR/xmlschema11-2/#dateTime
 */
class XsdDateTime extends AbstractRdfDatatype
{
    public function getName()
    {
        return 'xsd:dateTime';
    }

    public function getLabel()
    {
        return 'Date Time'; // @translate
    }

    public function form(PhpRenderer $view)
    {
        $element = new Element\DateTime('xsd-date-time');
        $element->setAttributes([
            'class' => 'value to-require xsd-date-time',
            'data-value-key' => '@value',
            // TODO This placeholder is not displayed.
            'placeholder' => '2018-01-23T12:34:56 [yyyy-mm-ddThh:mm:ss]',
        ]);
        return $view->formDateTime($element);
    }

    public function isValid(array $valueObject)
    {
        // Zend form filtered and checked the value already via DateTime().
        if (!isset($valueObject['@value'])) {
            return false;
        }
        // Check with the offical regex from the w3c.
        // @link https://www.w3.org/TR/xmlschema11-2/#nt-dateTimeRep
        $value = preg_replace('/\s+/', '', $valueObject['@value']);
        return strlen($value)
            && preg_match(
                '/-?([1-9][0-9]{3,}|0[0-9]{3})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])T(([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9](\.[0-9]+)?|(24:00:00(\.0+)?))(Z|(\+|-)((0[0-9]|1[0-3]):[0-5][0-9]|14:00))?/',
                $value
            );
    }

    public function hydrate(array $valueObject, Value $value, AbstractEntityAdapter $adapter)
    {
        $valueObject['@value'] = preg_replace('/\s+/', '', $valueObject['@value']);
        parent::hydrate($valueObject, $value, $adapter);
    }
}
