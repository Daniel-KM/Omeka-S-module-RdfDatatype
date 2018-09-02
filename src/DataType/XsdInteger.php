<?php
namespace RdfDatatype\DataType;

use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

/**
 * @url https://www.w3.org/TR/xmlschema11-2/#integer
 */
class XsdInteger extends AbstractRdfDatatype
{
    public function getName()
    {
        return 'xsd:integer';
    }

    public function getLabel()
    {
        return 'Integer'; // @translate
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
}
