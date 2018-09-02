<?php
namespace RdfDatatype\DataType;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Api\Representation\ValueRepresentation;
use Omeka\DataType\AbstractDataType;
use Omeka\Entity\Value;
use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

/**
 * @url http://www.w3.org/TR/xmlschema11-2/#decimal
 */
class XsdDecimal extends AbstractDataType
{
    public function getName()
    {
        return 'xsd:decimal';
    }

    public function getLabel()
    {
        return 'Decimal'; // @translate
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
        $element = new Element\Number('xsd-decimal');
        $element->setAttributes([
            'class' => 'value to-require xsd-decimal',
            'data-value-key' => '@value',
            'placeholder' => 'Input a decimal number…', // @translate
        ]);
        return $view->formText($element);
    }

    public function isValid(array $valueObject)
    {
        return isset($valueObject['@value'])
            && is_numeric(trim($valueObject['@value']));
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
