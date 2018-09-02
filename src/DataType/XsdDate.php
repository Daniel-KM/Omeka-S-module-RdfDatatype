<?php
namespace RdfDatatype\DataType;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Api\Representation\ValueRepresentation;
use Omeka\DataType\AbstractDataType;
use Omeka\Entity\Value;
use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

/**
 * @url http://www.w3.org/TR/xmlschema11-2/#date
 */
class XsdDate extends AbstractDataType
{
    public function getName()
    {
        return 'xsd:date';
    }

    public function getLabel()
    {
        return 'Date'; // @translate
    }

    public function getOptgroupLabel()
    {
        return 'RDF Datatype'; // @translate
    }

    public function prepareForm(PhpRenderer $view)
    {
        $view->headLink()->appendStylesheet($view->assetUrl('css/rdf-datatype.css', 'RdfDatatype'));
    }

    public function form(PhpRenderer $view)
    {
        $element = new Element\Date('xsd-date');
        $element->setAttributes([
            'class' => 'value to-require xsd-date',
            'data-value-key' => '@value',
        ]);
        return $view->formDate($element);
    }

    public function isValid(array $valueObject)
    {
        // Zend form filtered and checked the value already via DateTime(), and
        // normalized it as yyyy-mm-dd, so this second check is only a quick
        // check for external requests only.
        // Function checkdate() check only a Gregorian date, so it is useless.
        return isset($valueObject['@value'])
            && \DateTime::createFromFormat('Y-m-d', $valueObject['@value']) !== false;
    }

    public function hydrate(array $valueObject, Value $value, AbstractEntityAdapter $adapter)
    {
        $value->setValue(trim($valueObject['@value']));
        // Set defaults.
        $value->setLang(null);
        $value->setUri(null);
        $value->setValueResource(null);
    }

    public function render(PhpRenderer $view, ValueRepresentation $value)
    {
        return $value->value();
    }

    public function getJsonLd(ValueRepresentation $value)
    {
        return [
            '@value' => $value->value(),
        ];
    }
}
