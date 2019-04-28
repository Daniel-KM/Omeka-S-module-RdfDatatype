<?php
namespace RdfDatatype\DataType;

use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

/**
 * @url https://www.w3.org/TR/xmlschema11-2/#decimal
 */
class XsdDecimal extends AbstractRdfDatatype
{
    public function getName()
    {
        return 'xsd:decimal';
    }

    public function getLabel()
    {
        return 'Decimal'; // @translate
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
}
