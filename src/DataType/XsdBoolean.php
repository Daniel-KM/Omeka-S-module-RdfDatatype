<?php
namespace RdfDatatype\DataType;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Api\Representation\ValueRepresentation;
use Omeka\Entity\Value;
use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

/**
 * @link https://www.w3.org/TR/xmlschema11-2/#boolean
 */
class XsdBoolean extends AbstractRdfDatatype
{
    public function getName()
    {
        return 'xsd:boolean';
    }

    public function getLabel()
    {
        return 'Boolean'; // @translate
    }

    public function form(PhpRenderer $view)
    {
        $element = new Element\Checkbox('xsd-boolean-input');
        $element->setAttributes([
            'class' => 'input-value to-require xsd-boolean-input',
        ]);
        $hidden = new Element\Hidden('xsd-boolean');
        $hidden->setAttributes([
            'data-value-key' => '@value',
        ]);
        return $view->formCheckbox($element)
            . $view->formHidden($hidden);
    }

    public function isValid(array $valueObject)
    {
        return isset($valueObject['@value'])
            // See the lexical space of xsd:boolean.
            // @link https://www.w3.org/TR/xmlschema11-2/#f-booleanLexmap
            && in_array(trim($valueObject['@value']), ['0', '1', 'false', 'true'], true);
    }

    public function hydrate(array $valueObject, Value $value, AbstractEntityAdapter $adapter)
    {
        $val = in_array(trim($valueObject['@value']), ['1', 'true'], true) ? '1' : '0';
        $value->setValue($val);
        // Set defaults.
        $value->setLang(null);
        $value->setUri(null);
        $value->setValueResource(null);
    }

    public function render(PhpRenderer $view, ValueRepresentation $value)
    {
        return (int) $value->value()
            ? $view->translate('true') // @translate
            : $view->translate('false'); // @translate
    }
}
