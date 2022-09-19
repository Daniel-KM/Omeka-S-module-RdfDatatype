<?php
namespace RdfDatatype\DataType;

use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

/**
 * @link https://www.w3.org/TR/xmlschema11-2/#date
 */
class XsdDate extends AbstractRdfDatatype
{
    public function getName()
    {
        return 'xsd:date';
    }

    public function getLabel()
    {
        return 'Date'; // @translate
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
}
