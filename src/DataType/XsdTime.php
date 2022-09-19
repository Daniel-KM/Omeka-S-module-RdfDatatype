<?php
namespace RdfDatatype\DataType;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Entity\Value;
use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

/**
 * @link https://www.w3.org/TR/xmlschema11-2/#time
 */
class XsdTime extends AbstractRdfDatatype
{
    public function getName()
    {
        return 'xsd:time';
    }

    public function getLabel()
    {
        return 'Time'; // @translate
    }

    public function form(PhpRenderer $view)
    {
        // TODO Set a field with seconds for xsd:time.
        $element = new Element\Time('xsd-time');
        $element->setAttributes([
            'class' => 'value to-require xsd-time',
            'data-value-key' => '@value',
            'placeholder' => 'hh:mm:ss',
        ]);
        return $view->formTime($element);
    }

    public function isValid(array $valueObject)
    {
        // Zend form filtered and checked the value already via DateTime(), and
        // normalized it as hh:mm only, but xsd:time requires seconds.
        if (!isset($valueObject['@value'])) {
            return false;
        }
        // Check with the offical regex from the w3c.
        // @link https://www.w3.org/TR/xmlschema11-2/#nt-timeRep
        $value = preg_replace('/\s+/', '', $valueObject['@value']);
        return strlen($value)
            && preg_match(
                '/(([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9](\.[0-9]+)?|(24:00:00(\.0+)?))(Z|(\+|-)((0[0-9]|1[0-3]):[0-5][0-9]|14:00))?/',
                // TODO Default Zend form for time doesn't allow seconds, but xsd:time requires it.
                $value . ':00'
            );
    }

    public function hydrate(array $valueObject, Value $value, AbstractEntityAdapter $adapter)
    {
        $valueObject['@value'] = preg_replace('/\s+/', '', $valueObject['@value']);
        parent::hydrate($valueObject, $value, $adapter);
    }
}
