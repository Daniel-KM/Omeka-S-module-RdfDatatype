<?php
namespace RdfDatatype\DataType;

use Omeka\Api\Adapter\AbstractEntityAdapter;
use Omeka\Entity\Value;
use Zend\Form\Element;
use Zend\View\Renderer\PhpRenderer;

/**
 * @url https://www.w3.org/TR/rdf11-concepts/#section-html
 */
class RdfHtml extends AbstractRdfDatatype
{
    public function getName()
    {
        return 'rdf:HTML';
    }

    public function getLabel()
    {
        return 'Html';
    }

    public function form(PhpRenderer $view)
    {
        $element = new Element\Textarea('rdf-html');
        $element->setAttributes([
            'class' => 'value to-require rdf-html',
            'data-value-key' => '@value',
            'placeholder' => '<p>input <em>your</em> <strong>html</strong> content</p>', // @translate
        ]);
        return $view->formTextarea($element);
    }

    public function isValid(array $valueObject)
    {
        return true;
    }

    public function hydrate(array $valueObject, Value $value, AbstractEntityAdapter $adapter)
    {
        $value->setValue(trim($valueObject['@value']));
        // Set defaults.
        // According to the recommandation, the language must be included
        // explicitly in the HTML literal.
        // TODO Manage the language for html.
        $value->setLang(null);
        $value->setUri(null);
        $value->setValueResource(null);
    }
}
