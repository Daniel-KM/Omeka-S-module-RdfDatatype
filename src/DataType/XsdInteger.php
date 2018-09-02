<?php
namespace RdfDatatype\DataType;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Api\Representation\ValueRepresentation;
use Omeka\DataType\AbstractDataType;
use Omeka\Entity\Value;
use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

class XsdInteger extends AbstractDataType
{
    public function getName()
    {
        return 'xsd:integer';
    }

    public function getLabel()
    {
        return 'Integer'; // @translate
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
        $element = new Element\Number('xsd-integer');
        $element->setAttributes([
            'class' => 'value to-require xsd-integer',
            'data-value-key' => '@value',
            'placeholder' => 'Input an integer…', // @translate
        ]);
        return $view->formNumber($element);
    }

    public function isValid(array $valueObject)
    {
        return isset($valueObject['@value'])
            && ctype_digit(trim($valueObject['@value']));
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
